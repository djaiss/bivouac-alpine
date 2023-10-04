<?php

namespace App\Services;

use App\Models\TaskList;

class ToggleTaskList extends BaseService
{
    private TaskList $taskList;

    public function execute(int $taskListId): TaskList
    {
        $this->taskList = TaskList::findOrFail($taskListId);
        $this->toggle();

        return $this->taskList;
    }

    private function toggle(): void
    {
        $this->taskList->collapsed = ! $this->taskList->collapsed;
        $this->taskList->save();
    }
}
