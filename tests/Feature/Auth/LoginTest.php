<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_form_uses_https_when_request_arrives_through_a_tls_terminating_proxy(): void
    {
        $response = $this->get('/', [
            'X-Forwarded-Host' => 'dude-unopened-rocking.ngrok-free.dev',
            'X-Forwarded-Proto' => 'https',
        ]);

        $response->assertOk()
            ->assertSee('action="https://dude-unopened-rocking.ngrok-free.dev/login"', false);
    }

    public function test_login_accepts_a_username_without_a_custom_validation_rule(): void
    {
        $response = $this->post('/login', [
            'name' => 'petugas',
            'password' => '',
        ]);

        $response->assertRedirect()
            ->assertSessionHasErrors(['password']);
    }

    public function test_verified_user_can_log_in_and_reach_the_dashboard(): void
    {
        $user = User::factory()->create([
            'name' => 'petugas',
            'password' => Hash::make('CorrectHorseBattery!42'),
        ]);

        $response = $this->post('/login', [
            'name' => ' PETUGAS ',
            'password' => 'CorrectHorseBattery!42',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->get('/dashboard')->assertOk()->assertSee('Dashboard SIMPP');
    }

    public function test_invalid_credentials_show_a_generic_error(): void
    {
        User::factory()->create([
            'name' => 'petugas',
            'password' => Hash::make('CorrectHorseBattery!42'),
        ]);

        $response = $this->post('/login', [
            'name' => 'petugas',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect()
            ->assertSessionHasErrors([
                'name' => 'Nama atau kata sandi tidak valid.',
            ]);
        $this->assertGuest();
    }

    public function test_login_requires_a_username_and_password(): void
    {
        $response = $this->post('/login', [
            'name' => ['bukan-nama'],
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'password']);
        $this->assertGuest();
    }

    public function test_login_rejects_a_password_longer_than_72_bytes(): void
    {
        $response = $this->post('/login', [
            'email' => 'petugas@example.com',
            'password' => str_repeat('a', 73),
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    public function test_login_validates_non_string_username_input(): void
    {
        $response = $this->post('/login', [
            'name' => ['petugas'],
            'password' => 'some-password',
        ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertGuest();
    }

    public function test_unverified_user_is_redirected_to_email_verification(): void
    {
        $user = User::factory()->unverified()->create([
            'name' => 'petugas',
            'password' => Hash::make('CorrectHorseBattery!42'),
        ]);

        $response = $this->post('/login', [
            'name' => 'petugas',
            'password' => 'CorrectHorseBattery!42',
        ]);

        $response->assertRedirect(route('verification.notice'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_dashboard_requires_login_and_verified_email(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));

        $this->actingAs(User::factory()->unverified()->create())
            ->get('/dashboard')
            ->assertRedirect(route('verification.notice'));
    }

    public function test_login_is_rate_limited(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/login', [
                'name' => 'petugas',
                'password' => 'wrong-password',
            ])->assertRedirect();
        }

        $this->post('/login', [
            'name' => 'petugas',
            'password' => 'wrong-password',
        ])->assertTooManyRequests();

        $this->assertGuest();
    }

    public function test_logout_ends_the_authenticated_session(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post('/logout');

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
