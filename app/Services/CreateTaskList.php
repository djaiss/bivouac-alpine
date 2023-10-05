<?php

namespace App\Services;

use App\Models\TaskList;

class CreateTaskList extends BaseService
{
    private TaskList $taskList;
    private ?string $name;

    public function execute(?string $name = null): TaskList
    {
        $this->name = $name;
        $this->create();

        return $this->taskList;
    }

    private function create(): void
    {
        $this->taskList = TaskList::create([
            'organization_id' => auth()->user()->organization_id,
            'name' => $this->name ?? null,
        ]);
    }
}
