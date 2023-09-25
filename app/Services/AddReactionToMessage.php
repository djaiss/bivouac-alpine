<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Reaction;

class AddReactionToMessage extends BaseService
{
    private string $emoji;
    private Message $message;
    private Reaction $reaction;

    public function execute(string $emoji, int $messageId): Reaction
    {
        $this->emoji = $emoji;
        $this->message = Message::find($messageId);

        $this->create();
        $this->associate();

        return $this->reaction;
    }

    private function create(): void
    {
        $this->reaction = Reaction::create([
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->user()->id,
            'emoji' => $this->emoji,
        ]);
    }

    private function associate(): void
    {
        $this->message->reactions()->save($this->reaction);
    }
}
