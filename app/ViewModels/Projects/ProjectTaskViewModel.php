<?php

namespace App\ViewModels\Projects;

use App\Helpers\StringHelper;
use App\Models\Reaction;
use App\Models\Task;
use App\Models\User;
use App\ViewModels\ReactionViewModel;

class ProjectTaskViewModel
{
    public static function show(Task $task): array
    {
        $assignees = $task->users()
            ->get()
            ->map(fn (User $user) => [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
            ]);

        $reactions = $task->reactions()
            ->with('user')
            ->get()
            ->map(fn (Reaction $reaction) => ReactionViewModel::dto($reaction));

        return [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description ? StringHelper::parse($task->description) : null,
            'description_raw' => $task->description,
            'is_completed' => $task->is_completed,
            'assignees' => $assignees,
            'reactions' => $reactions,
        ];
    }
}
