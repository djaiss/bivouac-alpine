<?php

namespace App\Services;

use App\Models\Message;

class DestroyMessage extends BaseService
{
    public function execute(Message $message): void
    {
        $message->comments()->delete();
        $message->reactions()->delete();
        $message->taskLists()->delete();
        $message->delete();
    }
}
