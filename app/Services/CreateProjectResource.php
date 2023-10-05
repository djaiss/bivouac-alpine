<?php

namespace App\Services;

use App\Jobs\UpdateProjectLastUpdatedAt;
use App\Models\ProjectResource;

class CreateProjectResource extends BaseService
{
    public function execute(int $projectId, ?string $label, string $link): ProjectResource
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
