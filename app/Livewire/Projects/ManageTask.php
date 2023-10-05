<?php

namespace App\Livewire\Projects;

use App\Models\Task;
use App\Services\UpdateTask;
use App\ViewModels\Projects\ProjectTaskViewModel;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ManageTask extends Component
{
    #[Locked]
    public array $task;

    public bool $showAddTaskModal = false;

    #[Rule('required|min:1|max:255')]
    public string $title = '';

    #[Rule('nullable|min:1|max:65535')]
    public ?string $description = '';

    public function mount(array $task): void
    {
        $this->task = $task;
    }

    public function render(): View
    {
        return view('livewire.projects.task');
    }

    public function save(): void
    {
        $this->validate();

        $task = (new UpdateTask)->execute(
            taskId: $this->task['id'],
            title: $this->title,
            description: $this->task['description_raw'],
            isCompleted: $this->task['is_completed'],
        );

        $this->task = ProjectTaskViewModel::show($task);
    }

    public function checkTask(int $taskId): void
    {
        $task = Task::findOrFail($taskId);

        $task = (new UpdateTask)->execute(
            taskId: $taskId,
            title: $task->title,
            description: $task->description_raw,
            isCompleted: ! $task->is_completed,
        );

        $this->task = ProjectTaskViewModel::show($task);
    }
}
