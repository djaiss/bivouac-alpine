<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Reaction;

class AddReactionToComment extends BaseService
{
    private string $emoji;
    private Comment $comment;
    private Reaction $reaction;

    public function execute(string $emoji, int $commentId): Reaction
    {
        $this->emoji = $emoji;
        $this->comment = Comment::find($commentId);

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
        $this->comment->reactions()->save($this->reaction);
    }
}
