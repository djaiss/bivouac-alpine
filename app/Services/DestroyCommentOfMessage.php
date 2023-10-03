<?php

namespace App\Services;

use App\Models\Comment;

class DestroyCommentOfMessage extends BaseService
{
    private Comment $comment;

    public function execute(Comment $comment): void
    {
        $this->comment = $comment;

        $this->destroy();
    }

    private function destroy(): void
    {
        $this->comment->delete();
    }
}
