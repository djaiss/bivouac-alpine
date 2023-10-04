<?php

namespace Tests\Feature\Project;

use App\Livewire\Projects\ManageCommentReactions;
use App\Livewire\Projects\ManageMessageComments;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Organization;
use App\Models\Project;
use App\Models\Reaction;
use App\Models\TaskList;
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
        TaskList::factory()->create([
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
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

    /** @test */
    public function comment_can_be_edited(): void
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
        $comment = Comment::factory()->create([
            'body' => 'Nice comment',
            'commentable_id' => $message->id,
            'commentable_type' => Message::class,
        ]);

        $this->actingAs($user)
            ->put('/projects/' . $project->id . '/messages/' . $message->id . '/comments/' . $comment->id, [
                'body' => 'test',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('project.message.show', [
                'project' => $project,
                'message' => $message,
            ]);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'body' => 'test',
        ]);
    }

    /** @test */
    public function comment_can_be_deleted(): void
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
        $comment = Comment::factory()->create([
            'body' => 'Nice comment',
            'commentable_id' => $message->id,
            'commentable_type' => Message::class,
        ]);

        $this->actingAs($user)
            ->delete('/projects/' . $project->id . '/messages/' . $message->id . '/comments/' . $comment->id)
            ->assertStatus(302)
            ->assertRedirectToRoute('project.message.show', [
                'project' => $project,
                'message' => $message,
            ]);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    /** @test */
    public function reaction_component_exists_on_the_page(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
            'is_public' => true,
        ]);
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);
        Comment::factory()->create([
            'commentable_id' => $message->id,
            'commentable_type' => Message::class,
        ]);
        TaskList::factory()->create([
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
        ]);

        $this->actingAs($user)
            ->get('/projects/' . $project->id . '/messages/' . $message->id)
            ->assertSeeLivewire(ManageCommentReactions::class);
    }

    /** @test */
    public function we_can_add_a_reaction(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        Livewire::actingAs($user)
            ->test(ManageCommentReactions::class, [
                'commentId' => $comment->id,
                'reactions' => collect(),
            ])
            ->call('save', '👍')
            ->assertSee('👍');

        $this->assertDatabaseHas('reactions', [
            'reactionable_id' => $comment->id,
            'reactionable_type' => Comment::class,
            'emoji' => '👍',
        ]);
    }

    /** @test */
    public function we_can_remove_a_reaction(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();
        $reaction = Reaction::factory()->create([
            'reactionable_id' => $comment->id,
            'reactionable_type' => Comment::class,
            'user_id' => $user->id,
            'emoji' => '👍',
        ]);

        Livewire::actingAs($user)
            ->test(ManageCommentReactions::class, [
                'commentId' => $comment->id,
                'reactions' => $comment->reactions()->get()->map(fn (Reaction $reaction) => [
                    'id' => $reaction->id,
                    'emoji' => $reaction->emoji,
                    'author' => [
                        'id' => $reaction->user->id,
                        'name' => $reaction->user->name,
                        'avatar' => $reaction->user->avatar,
                    ],
                ]),
            ])
            ->call('destroy', $reaction->id);

        $this->assertDatabaseMissing('reactions', [
            'id' => $reaction->id,
        ]);
    }
}
