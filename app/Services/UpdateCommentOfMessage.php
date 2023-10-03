<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class UpdateCommentOfMessage extends BaseService
{
    private Comment $comment;
    private string $body;

    public function execute(Comment $comment, string $body): Comment
    {
        $this->comment = $comment;
        $this->body = $body;

        $this->edit();
        $this->markMessageAsUnreadForOtherUsers();

        return $this->comment;
    }

    private function edit(): void
    {
        $this->comment->body = $this->body;
        $this->comment->save();
    }

    private function markMessageAsUnreadForOtherUsers(): void
    {
        DB::table('message_read_status')
            ->where('message_id', $this->comment->commentable_id)
            ->delete();

        (new MarkMessageAsRead)->execute($this->comment->commentable_id);
    }
}
