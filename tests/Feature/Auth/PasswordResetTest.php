<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_reset_request_uses_a_generic_response(): void
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'petugas@example.com']);

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        $response->assertRedirect()
            ->assertSessionHas('status', 'Jika alamat email cocok dengan akun, tautan reset kata sandi akan dikirim.');
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_unknown_email_gets_the_same_password_reset_response(): void
    {
        Notification::fake();

        $response = $this->post('/forgot-password', ['email' => 'tidak-ada@example.com']);

        $response->assertRedirect()
            ->assertSessionHas('status', 'Jika alamat email cocok dengan akun, tautan reset kata sandi akan dikirim.');
        Notification::assertNothingSent();
    }

    public function test_valid_reset_token_changes_the_password(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewStrongPassword!42',
            'password_confirmation' => 'NewStrongPassword!42',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertTrue(Hash::check('NewStrongPassword!42', $user->fresh()->password));
    }

    public function test_password_reset_rejects_a_weak_password(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertFalse(Hash::check('short', $user->fresh()->password));
    }

    public function test_password_reset_rejects_a_password_that_exceeds_the_bcrypt_byte_limit(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);
        $password = str_repeat('😀', 19);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertFalse(Hash::check($password, $user->fresh()->password));
    }
}
