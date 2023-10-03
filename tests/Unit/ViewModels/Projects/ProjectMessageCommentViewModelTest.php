<?php

namespace Tests\Unit\ViewModels\Projects;

use App\Models\Comment;
use App\Models\Message;
use App\ViewModels\Projects\ProjectMessageCommentViewModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProjectMessageCommentViewModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_edit_view(): void
    {
        $message = Message::factory()->create([
            'title' => 'Microsoft',
        ]);
        $comment = Comment::factory()->create([
            'body' => 'this is my best friend',
            'commentable_id' => $message->id,
            'commentable_type' => Message::class,
        ]);

        $array = ProjectMessageCommentViewModel::edit($comment);

        $this->assertCount(4, $array);
        $this->assertEquals(
            $comment->id,
            $array['id']
        );
        $this->assertEquals(
            'this is my best friend',
            $array['body']
        );
        $this->assertEquals(
            $message->id,
            $array['message_id']
        );
        $this->assertEquals(
            'Microsoft',
            $array['message_title']
        );
    }

    /** @test */
    public function it_gets_the_delete_view(): void
    {
        $message = Message::factory()->create([
            'title' => 'Microsoft',
        ]);
        $comment = Comment::factory()->create([
            'commentable_id' => $message->id,
            'commentable_type' => Message::class,
        ]);

        $array = ProjectMessageCommentViewModel::delete($comment);

        $this->assertCount(3, $array);
        $this->assertEquals(
            $comment->id,
            $array['id']
        );
        $this->assertEquals(
            $message->id,
            $array['message_id']
        );
        $this->assertEquals(
            'Microsoft',
            $array['message_title']
        );
    }
}
