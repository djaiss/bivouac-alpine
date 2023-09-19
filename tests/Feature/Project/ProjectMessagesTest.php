<?php

namespace Tests\Feature\Project;

use App\Livewire\Projects\ManageProjectMembers;
use App\Models\Message;
use App\Models\Organization;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectMessagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_see_a_list_of_messages(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $organization->id,
            'first_name' => 'Regis',
        ]);
        $project = Project::factory()->create([
            'name' => 'Paper',
            'organization_id' => $organization->id,
            'is_public' => true,
        ]);
        $user->projects()->attach($project);
        Message::factory()->create([
            'project_id' => $project->id,
            'title' => 'this is my best friend',
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/messages')
            ->assertStatus(200)
            ->assertSee('this is my best friend');
    }
}
