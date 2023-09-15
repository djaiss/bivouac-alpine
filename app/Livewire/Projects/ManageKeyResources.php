<?php

namespace App\Livewire\Projects;

use App\Jobs\UpdateProjectLastUpdatedAt;
use App\Models\ProjectResource;
use App\Services\CreateProjectResource;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ManageKeyResources extends Component
{
    #[Locked]
    public int $projectId;

    public Collection $resources;
    public bool $showAddModal = false;
    public int $editedResourceId = 0;

    #[Rule('required|min:1|max:255')]
    public string $link = '';

    #[Rule('max:255')]
    public string $label = '';

    public function mount(array $data): void
    {
        $this->projectId = $data['project_id'];
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

    public function toggleEdit(int $resourceId = 0): void
    {
        $this->editedResourceId = $resourceId;

        if ($resourceId !== 0) {
            $resource = $this->resources->filter(function (array $value, int $key) use ($resourceId) {
                return $value['id'] === $resourceId;
            })->first();

            $this->label = $resource['label'];
            $this->link = $resource['link'];
        }
    }

    public function save(): void
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

    public function update(int $resourceId): void
    {
        $projectResource = ProjectResource::where('project_id', $this->projectId)
            ->findOrFail($resourceId);

        $this->editedResourceId = 0;

        $projectResource->link = $this->link;
        $projectResource->label = $this->label;
        $projectResource->save();

        $this->resources = $this->resources->map(function (array $value, int $key) use ($projectResource) {
            if ($value['id'] === $projectResource->id) {
                return [
                    'id' => $projectResource->id,
                    'label' => $projectResource->label,
                    'link' => $projectResource->link,
                ];
            }

            return $value;
        });

        $this->label = '';
        $this->link = '';

        UpdateProjectLastUpdatedAt::dispatch($this->projectId);
    }

    public function destroy(int $resourceId): void
    {
        $projectResource = ProjectResource::where('project_id', $this->projectId)
            ->findOrFail($resourceId);

        $projectResource->delete();

        UpdateProjectLastUpdatedAt::dispatch($this->projectId);

        $this->resources = $this->resources->filter(function (array $value, int $key) use ($projectResource) {
            return $value['id'] != $projectResource->id;
        });
    }
}
