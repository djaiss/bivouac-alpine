<?php

namespace App\Services;

use App\Models\Reaction;
use App\Models\Task;

class AddReactionToTask extends BaseService
{
    private string $emoji;
    private Task $task;
    private Reaction $reaction;

    public function execute(string $emoji, int $taskId): Reaction
    {
        $this->emoji = $emoji;
        $this->task = Task::find($taskId);

        $this->create();
        $this->associate();

        return $this->reaction;
    }

    private function create(): void
    {
        $this->reaction = Reaction::create([
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->user()->id,
            'emoji' => $this->emoji,
        ]);
    }

    private function associate(): void
    {
        $this->task->reactions()->save($this->reaction);
    }
}
