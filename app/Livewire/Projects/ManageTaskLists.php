<?php

namespace App\Livewire\Projects;

use App\Models\Task;
use App\Models\User;
use App\Services\CreateTask;
use App\Services\ToggleTaskList;
use App\Services\UpdateTask;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ManageTaskLists extends Component
{
    #[Locked]
    public array $taskList;

    /**
     * The context is the context this component is placed into. It can appear
     * at the Message level, or the Task level.
     */
    public string $context;

    public bool $collapsed = false;

    public bool $showAddTaskModal = false;

    public Collection $tasks;

    #[Rule('required|min:1|max:255')]
    public string $title = '';

    public function mount(array $taskList, string $context): void
    {
        $this->taskList = $taskList;
        $this->context = $context;
        $this->collapsed = $taskList['collapsed'];
        $this->tasks = $taskList['tasks'];
    }

    public function render(): View
    {
        return view('livewire.task-list');
    }

    public function toggle(): void
    {
        $this->collapsed = ! $this->collapsed;

        (new ToggleTaskList())->execute(
            taskListId: $this->taskList['id'],
        );
    }

    public function toggleAddModal(): void
    {
        $this->showAddTaskModal = ! $this->showAddTaskModal;
        $this->title = '';
    }

    public function save(): void
    {
        $this->validate();

        $task = (new CreateTask())->execute(
            taskListId: $this->taskList['id'],
            title: $this->title,
        );

        $this->tasks->push([
            'id' => $task->id,
            'title' => $this->title,
            'is_completed' => $task->is_completed,
            'assignees' => $task->users()
                ->get()
                ->map(fn (User $user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                ]),
            'url' => route('project.tasklist.task.show', [
                'project' => $this->taskList['parent']['id'],
                'tasklist' => $this->taskList['id'],
                'task' => $task->id,
            ]),
        ]);

        $this->toggleAddModal();
    }

    public function update(int $taskId): void
    {
        $this->validate();

        $task = Task::findOrFail($taskId);

        $task = (new UpdateTask())->execute(
            taskId: $taskId,
            title: $this->title,
            description: $task->description,
            isCompleted: $task->is_completed,
        );

        $this->refreshTaskList($task);
    }

    public function checkTask(int $taskId): void
    {
        $task = Task::findOrFail($taskId);

        $task = (new UpdateTask())->execute(
            taskId: $taskId,
            title: $task->title,
            description: $task->description,
            isCompleted: ! $task->is_completed,
        );

        $this->refreshTaskList($task);
    }

    public function refreshTaskList(Task $task): void
    {
        $this->tasks = $this->tasks->map(function (array $value, int $key) use ($task) {
            if ($value['id'] === $task->id) {
                return [
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
                    'url' => route('project.tasklist.task.show', [
                        'project' => $this->taskList['parent']['id'],
                        'tasklist' => $this->taskList['id'],
                        'task' => $task->id,
                    ]),
                ];
            }

            return $value;
        });
    }
}
