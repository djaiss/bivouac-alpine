<?php

namespace Tests\Feature\Project;

use App\Models\Organization;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_a_blank_list_of_projects(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $organization->id,
        ]);

        $this->actingAs($user)
            ->get('/projects')
            ->assertStatus(200)
            ->assertSee('You haven\'t started a project yet.');
    }

    /** @test */
    public function user_can_see_the_list_of_projects(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $organization->id,
        ]);
        Project::factory()->create([
            'name' => 'Paper',
            'organization_id' => $organization->id,
            'is_public' => true,
        ]);

        $this->actingAs($user)
            ->get('/projects')
            ->assertStatus(200)
            ->assertSee('Paper');
    }

    /** @test */
    public function user_cant_see_a_private_project_he_is_not_part_of(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $organization->id,
        ]);
        Project::factory()->create([
            'name' => 'Paper',
            'organization_id' => $organization->id,
            'is_public' => false,
        ]);

        $this->actingAs($user)
            ->get('/projects')
            ->assertStatus(200)
            ->assertSee('You haven\'t started a project yet.');
    }

    /** @test */
    public function any_user_can_create_a_new_project(): void
    {
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
        ]);

        $this->actingAs($user)
            ->post('/projects', [
                'name' => fake()->name,
                'description' => fake()->sentence,
                'is_public' => true,
            ])
            ->assertStatus(302);

        $user = User::factory()->create([
            'permissions' => User::ROLE_ADMINISTRATOR,
        ]);

        $this->actingAs($user)
            ->post('/projects', [
                'name' => fake()->name,
                'description' => fake()->sentence,
                'is_public' => true,
            ])
            ->assertStatus(302);

        $user = User::factory()->create([
            'permissions' => User::ROLE_ACCOUNT_MANAGER,
        ]);

        $this->actingAs($user)
            ->post('/projects', [
                'name' => fake()->name,
                'description' => fake()->sentence,
                'is_public' => true,
            ])
            ->assertStatus(302);
    }

    /** @test */
    public function user_can_see_the_settings_page_if_project_is_public(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $organization->id,
        ]);
        $project = Project::factory()->create([
            'organization_id' => $organization->id,
            'is_public' => true,
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id)
            ->assertStatus(200);
    }

    /** @test */
    public function user_cant_see_the_settings_page_if_project_is_private(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $organization->id,
        ]);
        $project = Project::factory()->create([
            'organization_id' => $organization->id,
            'is_public' => false,
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id)
            ->assertStatus(401);
    }

    /** @test */
    public function user_can_see_the_settings_page_if_project_is_private_but_is_part_of_the_project(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $organization->id,
        ]);
        $project = Project::factory()->create([
            'organization_id' => $organization->id,
            'is_public' => false,
        ]);
        $project->users()->attach($user);

        $this->actingAs($user)
            ->get('/projects/' . $project->id)
            ->assertStatus(200);
    }
}
