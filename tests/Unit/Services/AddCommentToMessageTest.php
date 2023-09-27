<?php

namespace Tests\Unit\Services;

use App\Models\Comment;
use App\Models\Message;
use App\Models\User;
use App\Services\AddCommentToMessage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddCommentToMessageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_comment(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();
        $this->be($user);

        $comment = (new AddCommentToMessage)->execute(
            messageId: $message->id,
            body: 'Dunder',
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
