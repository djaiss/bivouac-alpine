<?php

namespace App\ViewModels\Projects;

use App\Helpers\DateHelper;
use App\Helpers\StringHelper;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Project;
use App\Models\Reaction;
use Illuminate\Support\Facades\DB;

class ProjectMessageViewModel
{
    public static function index(Project $project): array
    {
        $messages = $project->messages()
            ->with('user')
            ->withCount('comments')
            ->orderByDesc('created_at')
            ->get();

        $readStatuses = DB::table('message_read_status')
            ->whereIn('message_id', $messages->pluck('id'))
            ->get();

        $messages = $messages->map(fn (Message $message) => self::message($message, $readStatuses->contains(
            fn ($readStatus) => $readStatus->message_id === $message->id &&
                $readStatus->user_id === auth()->user()->id
        )));

        return [
            'project_id' => $project->id,
            'messages' => $messages,
        ];
    }

    public static function message(Message $message, bool $isRead = false): array
    {
        return [
            'id' => $message->id,
            'title' => $message->title,
            'read' => $isRead,
            'author' => [
                'id' => $message->user_id,
                'name' => $message->user->name,
                'avatar' => $message->user->avatar,
            ],
        ];
    }

    public static function create(Project $project): array
    {
        return [
            'project_id' => $project->id,
        ];
    }

    public static function show(Message $message): array
    {
        $comments = $message->comments()
            ->with('user')
            ->with('reactions')
            ->orderBy('created_at')
            ->get()
            ->map(fn (Comment $comment) => [
                'id' => $comment->id,
                'project_id' => $message->project_id,
                'message_id' => $message->id,
                'author' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->name,
                    'avatar' => $comment->user->avatar,
                ],
                'body' => StringHelper::parse($comment->body),
                'body_raw' => $comment->body,
                'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                'reactions' => $comment->reactions->map(fn (Reaction $reaction) => [
                    'id' => $reaction->id,
                    'emoji' => $reaction->emoji,
                    'author' => [
                        'id' => $reaction->user->id,
                        'name' => $reaction->user->name,
                        'avatar' => $reaction->user->avatar,
                    ],
                ]),
            ]);

        $reactions = $message->reactions()
            ->with('user')
            ->get()
            ->map(fn (Reaction $reaction) => [
                'id' => $reaction->id,
                'emoji' => $reaction->emoji,
                'author' => [
                    'id' => $reaction->user->id,
                    'name' => $reaction->user->name,
                    'avatar' => $reaction->user->avatar,
                ],
            ]);

        return [
            'id' => $message->id,
            'title' => $message->title,
            'body' => StringHelper::parse($message->body),
            'created_at' => DateHelper::parse($message->created_at),
            'comments' => $comments,
            'reactions' => $reactions,
            'author' => [
                'id' => $message->user_id,
                'name' => $message->user->name,
                'avatar' => $message->user->avatar,
            ],
        ];
    }

    public static function edit(Message $message): array
    {
        return [
            'id' => $message->id,
            'title' => $message->title,
            'body' => StringHelper::parse($message->body),
            'body_raw' => $message->body,
        ];
    }

    public static function delete(Message $message): array
    {
        return [
            'id' => $message->id,
            'title' => $message->title,
        ];
    }
}
