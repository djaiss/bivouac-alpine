<?php

namespace Tests\Unit\Services;

use App\Models\Comment;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use App\Services\DestroyCommentOfMessage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DestroyCommentOfMessageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_deletes_a_comment(): void
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

        (new DestroyCommentOfMessage)->execute($comment);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }
}
