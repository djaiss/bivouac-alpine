<?php

namespace App\Services;

use App\Exceptions\NotEnoughPermissionException;
use App\Jobs\UpdateProjectLastUpdatedAt;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\User;

class CreateProjectResource extends BaseService
{
    public function execute(
        int $projectId,
        string $label = null,
        string $link,
    ): ProjectResource
    {
        $projectResource = ProjectResource::create([
            'project_id' => $projectId,
            'label' => $label,
            'link' => $link,
        ]);

        UpdateProjectLastUpdatedAt::dispatch($projectId);

        return $projectResource;
    }
}
