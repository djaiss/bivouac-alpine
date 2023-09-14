<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Services\CreateProjectResource;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ManageKeyResources extends Component
{
    #[Locked]
    public int $projectId;

    public Collection $resources;
    public bool $showAddModal = false;

    #[Rule('required|min:1|max:255')]
    public string $link = '';

    #[Rule('max:255')]
    public string $label = '';

    public function mount(array $data)
    {
        $this->projectId = $data['projectId'];
        $this->resources = $data['project_resources'];
    }

    public function render(): View
    {
        return view('livewire.projects.manage-key-resources');
    }

    public function toggle(): void
    {
        $this->label = '';
        $this->link = '';
        $this->showAddModal = ! $this->showAddModal;

        if ($this->showAddModal) {
            $this->dispatch('focus-label-field');
        }
    }

    public function save()
    {
        $this->validate();

        $resource = (new CreateProjectResource)->execute(
            projectId: $this->projectId,
            label: $this->label,
            link: $this->link,
        );

        $this->resources->push([
            'id' => $resource->id,
            'label' => $resource->label,
            'link' => $resource->link,
        ]);

        $this->toggle();
    }
}
