<?php

namespace Tests\Feature\Project;

use App\Livewire\Projects\ManageMessageComments;
use App\Models\Message;
use App\Models\Organization;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_exists_on_the_message_page(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/messages/' . $message->id)
            ->assertSeeLivewire(ManageMessageComments::class);
    }

    /** @test */
    public function comment_can_be_created(): void
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
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);

        Livewire::actingAs($user)
            ->test(ManageMessageComments::class, [
                'messageId' => $message->id,
                'comments' => collect(),
            ])
            ->set('value', 'Nice comment')
            ->call('save');

        $this->assertDatabaseHas('comments', [
            'commentable_type' => Message::class,
            'commentable_id' => $message->id,
            'body' => 'Nice comment',
        ]);
    }
}
