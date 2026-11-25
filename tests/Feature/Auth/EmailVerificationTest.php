<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_user_can_request_a_verification_email(): void
    {
        Notification::fake();
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->post('/email/verification-notification');

        $response->assertRedirect()
            ->assertSessionHas('status', 'Tautan verifikasi telah dikirim ke alamat email Anda.');
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_valid_signed_link_verifies_the_authenticated_user(): void
    {
        $user = User::factory()->unverified()->create();
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(30),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $response = $this->actingAs($user)->get($url);

        $response->assertRedirect(route('dashboard'));
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_invalid_signature_does_not_verify_the_email(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(route('verification.verify', [
            'id' => $user->id,
            'hash' => sha1($user->getEmailForVerification()),
        ]));

        $response->assertForbidden();
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    public function test_user_cannot_verify_another_users_email(): void
    {
        $authenticatedUser = User::factory()->unverified()->create();
        $targetUser = User::factory()->unverified()->create();
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(30),
            ['id' => $targetUser->id, 'hash' => sha1($targetUser->getEmailForVerification())]
        );

        $response = $this->actingAs($authenticatedUser)->get($url);

        $response->assertForbidden();
        $this->assertFalse($targetUser->fresh()->hasVerifiedEmail());
    }
}
