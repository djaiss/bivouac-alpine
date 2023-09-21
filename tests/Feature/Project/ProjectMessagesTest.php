<?php

namespace Tests\Feature\Project;

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

    /** @test */
    public function we_can_create_a_message(): void
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

        $this->actingAs($user)
            ->post('/projects/' . $project->id . '/messages', [
                'title' => 'Microsoft',
                'body' => 'this is my best friend',
            ])
            ->assertStatus(302);

        $this->assertDatabaseHas('messages', [
            'project_id' => $project->id,
            'title' => 'Microsoft',
            'body' => 'this is my best friend',
        ]);
    }
}
