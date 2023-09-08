<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_invited_user_can_use_the_invitation_to_create_an_account(): void
    {
        $user = User::factory()->create([]);

        $url = URL::temporarySignedRoute('invitation.validate.show', now()->addDays(3), [
            'code' => $user->invitation_code,
        ]);

        $this->post($url, [
            'password' => '7dEpygmY',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticated();
    }

    /** @test */
    public function an_invited_user_cant_use_the_invitation_to_create_an_account(): void
    {
        $user = User::factory()->create([]);

        $url = URL::temporarySignedRoute('invitation.validate.show', now()->addDays(3), [
            'code' => $user->invitation_code . '-invalid',
        ]);

        $this->post($url, [
            'password' => '7dEpygmY',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ])->assertRedirect('/');

        $this->assertGuest();
    }
}
