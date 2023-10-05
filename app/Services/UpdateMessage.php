<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Facades\DB;

class UpdateMessage extends BaseService
{
    private Message $message;
    private string $title;
    private string $body;

    public function execute(Message $message, string $title, string $body): Message
    {
        $this->message = $message;
        $this->title = $title;
        $this->body = $body;

        $this->edit();
        $this->resetReadStatus();
        $this->markAsRead();

        return $this->message;
    }

    private function edit(): void
    {
        $this->message->title = $this->title;
        $this->message->body = $this->body;
        $this->message->save();
    }

    private function resetReadStatus(): void
    {
        DB::table('message_read_status')
            ->where('message_id', $this->message->id)
            ->delete();
    }

    private function markAsRead(): void
    {
        (new MarkMessageAsRead())->execute($this->message->id);
    }
}
