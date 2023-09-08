<?php

namespace Tests\Feature\Project;

use App\Models\Organization;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_edit_a_project(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $organization->id,
        ]);
        $project = Project::factory()->create([
            'name' => 'Paper',
            'organization_id' => $organization->id,
            'is_public' => true,
        ]);

        $this->actingAs($user)
            ->put('/projects/' . $project->id, [
                'title' => 'Paper',
                'description' => 'Paper',
                'short_description' => 'Paper',
                'is_public' => 'true',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('project.edit', $project->id);
    }

    /** @test */
    public function user_can_delete_a_project(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'permissions' => User::ROLE_USER,
            'organization_id' => $organization->id,
        ]);
        $project = Project::factory()->create([
            'name' => 'Paper',
            'organization_id' => $organization->id,
            'is_public' => true,
        ]);

        $this->actingAs($user)
            ->delete('/projects/' . $project->id)
            ->assertStatus(302)
            ->assertRedirectToRoute('project.index');
    }
}
