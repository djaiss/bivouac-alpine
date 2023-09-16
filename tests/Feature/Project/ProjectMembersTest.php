<?php

namespace Tests\Feature\Project;

use App\Models\Organization;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectMembersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_see_a_list_of_members(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $organization->id,
            'first_name' => 'Regis',
        ]);
        $member = User::factory()->create([
            'organization_id' => $organization->id,
            'first_name' => 'Alexis',
        ]);
        $project = Project::factory()->create([
            'name' => 'Paper',
            'organization_id' => $organization->id,
            'is_public' => true,
        ]);
        $user->projects()->attach($project);
        $member->projects()->attach($project);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/members')
            ->assertStatus(200)
            ->assertSee('Regis')
            ->assertSee('Alexis');
    }

    /** @test */
    public function a_user_can_remove_a_member_from_the_project(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $organization->id,
        ]);
        $member = User::factory()->create([
            'organization_id' => $organization->id,
        ]);
        $project = Project::factory()->create([
            'name' => 'Paper',
            'organization_id' => $organization->id,
            'is_public' => true,
        ]);
        $user->projects()->attach($project);
        $member->projects()->attach($project);

        $this->actingAs($user)
            ->delete('/projects/' . $project->id . '/members/' . $member->id)
            ->assertStatus(302)
            ->assertRedirectToRoute('project.member.index', $project->id);

        $this->assertDatabaseMissing('project_user', [
            'project_id' => $project->id,
            'user_id' => $member->id,
        ]);
    }
}
