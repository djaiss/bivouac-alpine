<?php

namespace Tests\Feature\Settings\Organization;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_the_organization_update_page(): void
    {
        $organization = Organization::factory()->create([
            'name' => 'Bivouac',
        ]);
        $john = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
            'organization_id' => $organization->id,
        ]);
        $oliver = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $organization->id,
        ]);

        $this->actingAs($oliver)
            ->get('/settings/organization')
            ->assertStatus(401);

        $this->actingAs($john)
            ->get('/settings/organization')
            ->assertStatus(200);
    }

    /** @test */
    public function an_administrator_can_update_the_organization_name(): void
    {
        $user = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);

        $this->actingAs($user)
            ->post('/settings/organization', [
                'name' => 'Microsoft',
            ])
            ->assertStatus(302);

        $this->assertEquals('Microsoft', $user->organization->refresh()->name);
    }

    /** @test */
    public function a_user_cant_update_the_organization_name(): void
    {
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
        ]);

        $this->actingAs($user)
            ->post('/settings/organization', [
                'name' => 'Microsoft',
            ])
            ->assertStatus(401);
    }

    /** @test */
    public function only_the_account_manager_can_see_the_delete_account_page(): void
    {
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
        ]);

        $this->actingAs($user)
            ->get('/settings/delete')
            ->assertStatus(401);

        $administrator = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);

        $this->actingAs($administrator)
            ->get('/settings/delete')
            ->assertStatus(401);

        $accountManager = User::factory()->create([
            'permissions' => User::ROLE_ACCOUNT_MANAGER,
        ]);

        $this->actingAs($accountManager)
            ->get('/settings/delete')
            ->assertStatus(200);
    }

    /** @test */
    public function only_the_account_manager_can_delete_an_account(): void
    {
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
        ]);

        $this->actingAs($user)
            ->delete('/settings')
            ->assertStatus(401);

        $administrator = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);

        $this->actingAs($administrator)
            ->delete('/settings')
            ->assertStatus(401);

        $accountManager = User::factory()->create([
            'permissions' => User::ROLE_ACCOUNT_MANAGER,
        ]);

        $this->actingAs($accountManager)
            ->delete('/settings')
            ->assertStatus(302);
    }
}
