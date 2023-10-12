<?php

namespace App\ViewModels\Projects;

use App\Helpers\DateHelper;
use App\Helpers\StringHelper;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\Reaction;
use App\ViewModels\ReactionViewModel;
use Illuminate\Support\Facades\DB;

class ProjectResourceViewModel
{
    public static function index(Project $project): array
    {
        $resources = $project->projectResources()
            ->get()
            ->map(fn (ProjectResource $projectResource) => self::dto($projectResource));

        return [
            'project_resources' => $resources,
            'url' => [
                'resource' => [
                    'create' => route('project.resource.create', ['project' => $project->id]),
                ],
            ],
        ];
    }

    public static function dto(ProjectResource $projectResource): array
    {
        return [
            'id' => $projectResource->id,
            'label' => $projectResource->label,
            'link' => $projectResource->link,
            'url' => [
                'index' => route('project.resource.index', [
                    'project' => $projectResource->project_id,
                ]),
                'edit' => route('project.resource.edit', [
                    'project' => $projectResource->project_id,
                    'resource' => $projectResource->id,
                ]),
                'update' => route('project.resource.update', [
                    'project' => $projectResource->project_id,
                    'resource' => $projectResource->id,
                ]),
                'destroy' => route('project.resource.destroy', [
                    'project' => $projectResource->project_id,
                    'resource' => $projectResource->id,
                ]),
            ],
        ];
    }

    public static function create(Project $project): array
    {
        return [
            'url' => [
                'resource' => [
                    'index' => route('project.resource.index', ['project' => $project->id]),
                    'store' => route('project.resource.store', ['project' => $project->id]),
                ],
            ],
        ];
    }
}
