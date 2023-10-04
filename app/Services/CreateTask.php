<?php

namespace App\Services;

use App\Models\Task;

class CreateTask extends BaseService
{
    private Task $task;
    private int $taskListId;
    private string $title;

    public function execute(int $taskListId, string $title): Task
    {
        $this->taskListId = $taskListId;
        $this->title = $title;
        $this->create();

        return $this->task;
    }

    private function create(): void
    {
        $this->task = Task::create([
            'task_list_id' => $this->taskListId,
            'title' => $this->title,
        ]);
    }
}
