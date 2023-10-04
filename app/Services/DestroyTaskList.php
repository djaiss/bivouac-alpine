<?php

namespace App\Services;

use App\Models\TaskList;

class DestroyTaskList extends BaseService
{
    public function execute(TaskList $taskList): void
    {
        $taskList->delete();
    }
}
