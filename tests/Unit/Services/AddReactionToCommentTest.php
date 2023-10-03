<?php

namespace Tests\Unit\Services;

use App\Models\Comment;
use App\Models\Message;
use App\Models\Project;
use App\Models\Reaction;
use App\Models\User;
use App\Services\AddReactionToComment;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddReactionToCommentTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_reaction(): void
    {
        $user = User::factory()->create();
        $this->be($user);
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);
        $user->projects()->attach($project->id);
        $comment = Comment::factory()->create([
            'commentable_id' => $message->id,
            'commentable_type' => Message::class,
        ]);

        $reaction = (new AddReactionToComment)->execute(
            emoji: '🥳',
            commentId: $comment->id,
        );

        $this->assertInstanceOf(
            Reaction::class,
            $reaction
        );

        $this->assertDatabaseHas('reactions', [
            'id' => $reaction->id,
            'organization_id' => $user->organization_id,
            'emoji' => '🥳',
            'reactionable_id' => $comment->id,
            'reactionable_type' => Comment::class,
        ]);
    }
}
