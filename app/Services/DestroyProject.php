<?php

namespace App\Services;

use App\Models\Project;

class DestroyProject extends BaseService
{
    public function execute(Project $project): void
    {
        $project->delete();
    }
}
