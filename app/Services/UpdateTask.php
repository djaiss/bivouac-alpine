<?php

namespace App\Services;

use App\Models\Task;

class UpdateTask extends BaseService
{
    private Task $task;
    private string $title;
    private bool $isCompleted;

    public function execute(int $taskId, string $title, bool $isCompleted): Task
    {
        $this->task = Task::findOrFail($taskId);
        $this->title = $title;
        $this->isCompleted = $isCompleted;

        $this->edit();

        return $this->task;
    }

    private function edit(): void
    {
        $this->task->title = $this->title;
        $this->task->is_completed = $this->isCompleted;
        $this->task->save();
    }
}
