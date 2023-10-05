<?php

namespace App\Services;

use App\Models\Project;

class UpdateProject extends BaseService
{
    public function execute(
        Project $project,
        string $name,
        ?string $description = null,
        ?string $shortDescription = null,
        bool $isPublic = true
    ): Project {
        $project->name = $name;
        $project->description = $description;
        $project->short_description = $shortDescription;
        $project->is_public = $isPublic;
        $project->save();

        return $project;
    }
}
