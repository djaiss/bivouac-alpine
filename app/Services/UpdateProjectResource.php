<?php

namespace App\Services;

use App\Jobs\UpdateProjectLastUpdatedAt;
use App\Models\Comment;
use App\Models\ProjectResource;

class UpdateProjectResource extends BaseService
{
    public function execute(ProjectResource $projectResource, string $link, string $label): void
    {
        $projectResource->link = $link;
        $projectResource->label = $label;
        $projectResource->save();

        UpdateProjectLastUpdatedAt::dispatch($projectResource->project_id);
    }
}
