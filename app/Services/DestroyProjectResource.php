<?php

namespace App\Services;

use App\Exceptions\NotEnoughPermissionException;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\User;

class DestroyProjectResource extends BaseService
{
    public function execute(ProjectResource $projectResource): void
    {
        $projectResource->project->updated_at = now();
        $projectResource->project->save();

        $projectResource->delete();
    }
}
