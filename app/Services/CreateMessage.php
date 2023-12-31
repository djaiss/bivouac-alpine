<?php

namespace App\Services;

use App\Models\Message;

class CreateMessage extends BaseService
{
    private Message $message;
    private int $projectId;
    private string $title;
    private string $body;

    public function execute(int $projectId, string $title, string $body): Message
    {
        $this->projectId = $projectId;
        $this->title = $title;
        $this->body = $body;

        $this->create();
        $this->markAsRead();
        $this->createDefaultEmptyTaskList();

        return $this->message;
    }

    private function create(): void
    {
        $this->message = Message::create([
            'project_id' => $this->projectId,
            'user_id' => auth()->user()->id,
            'title' => $this->title,
            'body' => $this->body,
        ]);
    }

    private function markAsRead(): void
    {
        (new MarkMessageAsRead)->execute($this->message->id);
    }

    /**
     * We also create a default, empty task list for storing future potential
     * tasks on this list.
     * A message can only have one task list, so it's easier to actually create
     * it here, rather than having to deal with it later.
     */
    private function createDefaultEmptyTaskList(): void
    {
        $taskList = (new CreateTaskList)->execute(
            name: null,
        );
        $taskList->project_id = $this->projectId;
        $taskList->tasklistable_id = $this->message->id;
        $taskList->tasklistable_type = Message::class;
        $taskList->save();
    }
}
