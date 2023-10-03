<?php

namespace App\ViewModels\Projects;

use App\Models\Comment;

class ProjectMessageCommentViewModel
{
    public static function edit(Comment $comment): array
    {
        return [
            'id' => $comment->id,
            'body' => $comment->body,
            'message_id' => $comment->commentable_id,
            'message_title' => $comment->commentable->title,
        ];
    }

    public static function delete(Comment $comment): array
    {
        return [
            'id' => $comment->id,
            'message_id' => $comment->commentable_id,
            'message_title' => $comment->commentable->title,
        ];
    }
}
