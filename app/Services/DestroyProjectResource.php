<?php

namespace App\Services;

use App\Jobs\UpdateProjectLastUpdatedAt;
use App\Models\Comment;
use App\Models\ProjectResource;

class DestroyProjectResource extends BaseService
{
    private ProjectResource $projectResource;

    public function execute(ProjectResource $projectResource): void
    {
        $this->projectResource = $projectResource;

        UpdateProjectLastUpdatedAt::dispatch($projectResource->project_id);

        $this->destroy();
    }

    private function destroy(): void
    {
        $this->projectResource->delete();
    }
}
