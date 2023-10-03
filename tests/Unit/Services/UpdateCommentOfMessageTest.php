<?php

namespace Tests\Unit\Services;

use App\Models\Comment;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Services\UpdateCommentOfMessage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateCommentOfMessageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_comment(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $user->projects()->attach($project->id);
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);
        $comment = Comment::factory()->create([
            'organization_id' => $user->organization_id,
            'commentable_id' => $message->id,
            'commentable_type' => Message::class,
        ]);

        $this->be($user);

        $comment = (new UpdateCommentOfMessage)->execute(
            comment: $comment,
            body: 'Dunder'
        );

        $this->assertInstanceOf(
            Comment::class,
            $comment
        );

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'organization_id' => $user->organization_id,
            'body' => 'Dunder',
            'commentable_id' => $message->id,
            'commentable_type' => Message::class,
        ]);

        $this->assertDatabaseHas('message_read_status', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);
    }
}
