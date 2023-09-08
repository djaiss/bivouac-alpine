<?php

namespace App\Services;

use App\Exceptions\NotEnoughPermissionException;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\User;

class CreateProjectResource extends BaseService
{
    public function execute(
        Project $project,
        string $name = null,
        string $link,
    ): ProjectResource
    {
        $projectResource = ProjectResource::create([
            'project_id' => $project->id,
            'name' => $name,
            'link' => $link,
        ]);

        $project->updated_at = now();
        $project->save();

        return $projectResource;
    }
}
