<?php

namespace Tests\Feature\Settings\User;

use App\Mail\UserInvited;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_page_lists_a_list_of_users(): void
    {
        $john = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);
        $oliver = User::factory()->create([
            'first_name' => 'Oliver',
            'last_name' => 'Queen',
            'permissions' => User::ROLE_USER,
            'organization_id' => $john->organization_id,
        ]);

        $this->actingAs($oliver)
            ->get('/settings')
            ->assertStatus(401);

        $this->actingAs($oliver)
            ->get('/settings/users')
            ->assertStatus(401);

        $this->actingAs($john)
            ->get('/settings')
            ->assertStatus(200);

        $this->actingAs($john)
            ->get('/settings/users')
            ->assertSee('John Doe')
            ->assertSee('Oliver Queen');
    }

    /** @test */
    public function an_administrator_can_send_an_invite_to_a_new_user(): void
    {
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
        ]);

        $this->actingAs($user)
            ->post('/settings/users/invite', [
                'email' => fake()->email,
            ])
            ->assertStatus(401);

        $user = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);

        Mail::fake();

        $email = fake()->email;
        $this->actingAs($user)
            ->post('/settings/users/invite', [
                'email' => $email,
            ])
            ->assertRedirectToRoute('settings.user.index');

        $this->actingAs($user)
            ->get('/settings/users')
            ->assertSee($email);

        Mail::assertQueued(UserInvited::class);
    }

    /** @test */
    public function a_user_can_be_edited(): void
    {
        $john = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);
        $oliver = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $john->organization_id,
        ]);

        $this->actingAs($john)
            ->put('/settings/users/' . $oliver->id, [
                'permissions' => User::ROLE_ADMINISTRATOR,
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('settings.user.index');
    }

    /** @test */
    public function a_user_cant_be_edited(): void
    {
        $john = User::factory()->create([
            'permissions' => User::ROLE_USER,
        ]);
        $oliver = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $john->organization_id,
        ]);

        $this->actingAs($john)
            ->put('/settings/users/' . $oliver->id, [
                'permissions' => User::ROLE_ADMINISTRATOR,
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function a_user_can_be_deleted(): void
    {
        $john = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);
        $oliver = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $john->organization_id,
        ]);

        $this->actingAs($john)
            ->get('/settings/users/' . $oliver->id . '/delete')
            ->assertStatus(200);

        $this->actingAs($john)
            ->delete('/settings/users/' . $oliver->id)
            ->assertStatus(302)
            ->assertRedirectToRoute('settings.user.index');
    }

    /** @test */
    public function a_user_cant_be_deleted(): void
    {
        $john = User::factory()->create([
            'permissions' => User::ROLE_USER,
        ]);
        $oliver = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $john->organization_id,
        ]);

        $this->actingAs($john)
            ->get('/settings/users/' . $oliver->id . '/delete')
            ->assertStatus(401);

        $this->actingAs($john)
            ->delete('/settings/users/' . $oliver->id)
            ->assertStatus(401);
    }

    /** @test */
    public function a_user_can_resend_an_invitation(): void
    {
        $john = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);
        $oliver = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $john->organization_id,
            'invitation_code' => null,
        ]);

        $this->actingAs($john)
            ->post('/settings/users/' . $oliver->id . '/send')
            ->assertStatus(302);

        $this->assertNotNull($oliver->refresh()->invitation_code);
    }
}
