<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use App\ViewModels\Projects\ProjectMemberViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ManageProjectMembers extends Component
{
    #[Locked]
    public int $projectId;

    public Collection $members;
    public Collection $potentialMembers;
    public Project $project;

    public bool $showAddModal = false;

    #[Rule('required|min:1|max:255')]
    public string $link = '';

    #[Rule('max:255')]
    public string $label = '';

    public function mount(array $data): void
    {
        $this->project = Project::findOrFail($data['project_id']);
        $this->projectId = $data['project_id'];
        $this->members = $data['members'];
    }

    public function render(): View
    {
        return view('livewire.projects.manage-project-members');
    }

    public function toggle(): void
    {
        $this->showAddModal = ! $this->showAddModal;
        $this->potentialMembers = ProjectMemberViewModel::listUsers(
            user: auth()->user(),
            project: $this->project,
        );
    }

    public function add(int $userId): void
    {
        $this->project->users()->syncWithoutDetaching($userId);

        $user = User::findOrFail($userId);
        $this->members->push([
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
        ]);

        $this->showAddModal = false;
    }
}
