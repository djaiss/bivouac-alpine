<?php

namespace Tests\Feature\Settings\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_see_his_own_edit_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/users/' . $user->id . '/edit')
            ->assertStatus(200);
    }

    /** @test */
    public function another_normal_user_cant_see_the_edit_page_of_another_user(): void
    {
        $normalUser = User::factory()->create([
            'permissions' => User::ROLE_USER,
        ]);
        $otherNormalUser = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $normalUser->organization_id,
        ]);

        $this->actingAs($normalUser)
            ->get('/users/' . $otherNormalUser->id . '/edit')
            ->assertStatus(401);
    }

    /** @test */
    public function an_administrator_can_see_the_edit_page_of_another_user(): void
    {
        $administrator = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);
        $otherNormalUser = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $administrator->organization_id,
        ]);

        $this->actingAs($administrator)
            ->get('/users/' . $otherNormalUser->id . '/edit')
            ->assertStatus(200);
    }

    /** @test */
    public function a_user_can_change_avatar(): void
    {
        $user = User::factory()->create();
        $previousAvatar = $user->avatar;

        $this->actingAs($user)
            ->put('/users/' . $user->id . '/avatar')
            ->assertStatus(302)
            ->assertRedirect('/users/' . $user->id . '/edit');

        $this->assertNotEquals($previousAvatar, $user->fresh()->avatar);
    }
}
