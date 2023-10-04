<?php

namespace App\Services;

use App\Models\TaskList;

class UpdateTaskList extends BaseService
{
    private TaskList $taskList;
    private string $name;

    public function execute(TaskList $taskList, string $name): TaskList
    {
        $this->taskList = $taskList;
        $this->name = $name;

        $this->edit();

        return $this->taskList;
    }

    private function edit(): void
    {
        $this->taskList->name = $this->name;
        $this->taskList->save();
    }
}
