<?php

namespace App\ViewModels\Projects;

use App\Models\Message;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectMessageViewModel
{
    public static function index(Project $project): array
    {
        $messages = $project->messages()
            ->with('creator')
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
                'name' => $message->authorName,
                'avatar' => $message?->creator?->avatar,
            ],
        ];
    }

    public static function create(Project $project): array
    {
        return [
            'project_id' => $project->id,
        ];
    }
}
