<?php

namespace App\Services;

use App\Models\Task;

class UpdateTask extends BaseService
{
    private Task $task;
    private string $title;
    private ?string $description;
    private bool $isCompleted;

    public function execute(int $taskId, string $title, ?string $description, bool $isCompleted): Task
    {
        $this->task = Task::findOrFail($taskId);
        $this->title = $title;
        $this->description = $description;
        $this->isCompleted = $isCompleted;

        $this->edit();

        return $this->task;
    }

    private function edit(): void
    {
        $this->task->title = $this->title;
        $this->task->is_completed = $this->isCompleted;
        $this->task->description = $this->description;
        $this->task->save();
    }
}
