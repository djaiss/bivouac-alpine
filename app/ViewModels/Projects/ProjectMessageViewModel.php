<?php

namespace App\ViewModels\Projects;

use App\Helpers\DateHelper;
use App\Helpers\StringHelper;
use App\Models\Message;
use App\Models\Project;
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
        return [
            'id' => $message->id,
            'title' => $message->title,
            'body' => StringHelper::parse($message->body),
            'created_at' => DateHelper::parse($message->created_at),
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
