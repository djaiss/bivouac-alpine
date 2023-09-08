<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /** @test */
    public function new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Henri',
            'last_name' => 'Troyat',
            'email' => 'test@example.com',
            'password' => '7dEpygmY',
            'password_confirmation' => '7dEpygmY',
            'organization_name' => 'bivouac',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /** @test */
    public function user_cant_register_with_a_leaked_password(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Henri',
            'last_name' => 'Troyat',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'organization_name' => 'bivouac',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors([
            'password' => 'The given password has appeared in a data leak. Please choose a different password.',
        ]);
    }
}
