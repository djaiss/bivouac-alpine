<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class AddCommentToMessage extends BaseService
{
    private Comment $comment;
    private Message $message;
    private string $body;

    public function execute(int $messageId, string $body): Comment
    {
        $this->message = Message::findOrFail($messageId);
        $this->body = $body;

        $this->create();
        $this->associate();
        $this->markMessageAsUnreadForOtherUsers();

        return $this->comment;
    }

    private function create(): void
    {
        $this->comment = Comment::create([
            'message_id' => $this->message->id,
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->user()->id,
            'body' => $this->body,
        ]);
    }

    private function associate(): void
    {
        $this->message->comments()->save($this->comment);
    }

    private function markMessageAsUnreadForOtherUsers(): void
    {
        DB::table('message_read_status')
            ->where('message_id', $this->message->id)
            ->delete();

        (new MarkMessageAsRead())->execute($this->message->id);
    }
}
