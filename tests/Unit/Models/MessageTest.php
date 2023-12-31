<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Message;
use App\Models\Reaction;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_one_project(): void
    {
        $message = Message::factory()->create();

        $this->assertTrue($message->project()->exists());
    }

    /** @test */
    public function it_belongs_to_one_creator(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue($message->user()->exists());
    }

    /** @test */
    public function it_has_many_comments(): void
    {
        $message = Message::factory()->create();
        Comment::factory()->create([
            'commentable_id' => $message->id,
            'commentable_type' => Message::class,
        ]);

        $this->assertTrue($message->comments()->exists());
    }

    /** @test */
    public function it_has_many_reactions(): void
    {
        $message = Message::factory()->create();
        Reaction::factory()->create([
            'reactionable_id' => $message->id,
            'reactionable_type' => Message::class,
        ]);

        $this->assertTrue($message->reactions()->exists());
    }

    /** @test */
    public function it_has_many_task_lists(): void
    {
        $message = Message::factory()->create();
        TaskList::factory()->create([
            'tasklistable_id' => $message->id,
            'tasklistable_type' => Message::class,
        ]);

        $this->assertTrue($message->taskLists()->exists());
    }
}
