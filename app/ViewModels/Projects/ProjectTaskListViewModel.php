<?php

namespace App\ViewModels\Projects;

use App\Models\Message;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;

class ProjectTaskListViewModel
{
    public static function index(Project $project): array
    {
        $taskLists = $project->taskLists()
            ->where(function ($query): void {
                $query->where('tasklistable_type', Project::class)
                    ->orWhere(function ($query): void {
                        $query->where('tasklistable_type', Message::class)
                            ->whereHas('tasks');
                    });
            })
            ->get()
            ->map(fn (TaskList $taskList) => self::dto($taskList));

        return [
            'task_lists' => $taskLists,
        ];
    }

    public static function dto(TaskList $taskList): array
    {
        $tasks = $taskList->tasks()
            ->get();

        $tasksCount = $tasks->count();
        $completionRate = $tasksCount > 0 ? $tasks->filter(fn (Task $task) => $task->is_completed)->count() / $tasksCount : 0;
        $completionRate = round($completionRate * 100);

        $parentUrl = match ($taskList->tasklistable_type) {
            Project::class => '',
            Message::class => route('project.message.show', [
                'project' => $taskList->tasklistable->project_id,
                'message' => $taskList->tasklistable->id,
            ]),
            default => '',
        };

        $tasks = $tasks->map(fn (Task $task) => [
            'id' => $task->id,
            'title' => $task->title,
            'is_completed' => $task->is_completed,
            'assignees' => $task->users()
                ->get()
                ->map(fn (User $user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                ]),
        ]);

        return [
            'id' => $taskList->id,
            'name' => $taskList->name,
            'tasks' => $tasks,
            'completion_rate' => $completionRate,
            'collapsed' => $taskList->collapsed,
            'parent' => [
                'id' => $taskList->tasklistable->id,
                'title' => $taskList->tasklistable->title,
                'is_project' => $taskList->tasklistable_type === Project::class,
                'url' => $parentUrl,
            ],
        ];
    }

    public static function edit(TaskList $taskList): array
    {
        return [
            'id' => $taskList->id,
            'title' => $taskList->name,
        ];
    }

    public static function delete(TaskList $taskList): array
    {
        return [
            'id' => $taskList->id,
        ];
    }
}
