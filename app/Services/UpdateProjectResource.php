<?php

namespace App\Services;

use App\Exceptions\NotEnoughPermissionException;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\User;

class UpdateProjectResource extends BaseService
{
    public function execute(
        ProjectResource $projectResource,
        string $name = null,
        string $link,
    ): ProjectResource
    {
        $projectResource->link = $link;
        $projectResource->name = $name;
        $projectResource->save();

        $projectResource->project->updated_at = now();
        $projectResource->project->save();

        return $projectResource;
    }
}
