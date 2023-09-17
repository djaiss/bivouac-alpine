<?php

namespace App\Services;

use App\Models\Project;

class CreateProject extends BaseService
{
    private Project $project;
    private string $name;
    private string $description;
    private bool $isPublic;

    public function execute(
        string $name,
        string $description,
        bool $isPublic): Project
    {
        $this->name = $name;
        $this->description = $description;
        $this->isPublic = $isPublic;

        $this->create();
        $this->associateUser();

        return $this->project;
    }

    private function create(): void
    {
        $this->project = Project::create([
            'organization_id' => auth()->user()->organization_id,
            'author_id' => auth()->user()->id,
            'author_name' => auth()->user()->name,
            'name' => $this->name,
            'short_description' => $this->description,
            'is_public' => $this->isPublic,
        ]);
    }

    private function associateUser(): void
    {
        $this->project->users()->syncWithoutDetaching([auth()->user()]);
    }
}
