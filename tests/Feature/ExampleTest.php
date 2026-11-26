<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_homepage_renders_the_login_screen(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Masuk ke SIMPP')
            ->assertSee('Alamat email')
            ->assertSee('Kata sandi');
    }
}
