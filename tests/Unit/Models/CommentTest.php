<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_one_organization(): void
    {
        $comment = Comment::factory()->create();

        $this->assertTrue($comment->organization()->exists());
    }

    /** @test */
    public function it_belongs_to_one_user(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue($comment->user()->exists());
    }

    /** @test */
    public function it_has_many_reactions(): void
    {
        $comment = Comment::factory()->create();
        Reaction::factory()->create([
            'reactionable_id' => $comment->id,
            'reactionable_type' => Comment::class,
        ]);

        $this->assertTrue($comment->reactions()->exists());
    }

    /** @test */
    public function it_gets_the_object_the_comment_is_about(): void
    {
        $comment = Comment::factory()->create();

        $this->assertInstanceOf(
            Project::class,
            $comment->commentable
        );
    }
}
