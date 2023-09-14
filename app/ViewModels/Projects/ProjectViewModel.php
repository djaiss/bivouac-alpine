<?php

namespace App\ViewModels\Projects;

use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\User;
use Illuminate\Support\Str;

class ProjectViewModel
{
    public static function index(User $user): array
    {
        $organization = $user->organization;

        // we make sure users can't see projects they don't belong to
        $projects = $organization->projects()
            ->with('users')
            ->withCount('users')
            ->orderBy('name')
            ->get()
            ->filter(function (Project $project) use ($user) {
                $userBelongsToProject = $project->users()->where('user_id', $user->id)->exists();

                return $project->is_public || (! $project->is_public && $userBelongsToProject);
            })
            ->map(function (Project $project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'short_description' => $project->short_description,
                    'is_public' => $project->is_public,
                    'updated_at' => $project->updated_at->ago(),
                    'members' => $project->users->random($project->users_count > 4 ? 4 : $project->users_count)
                        ->map(fn (User $user) => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'avatar' => $user->avatar,
                        ]),
                    'other_members_counter' => max(0, $project->users_count - 4),
                ];
            })
            ->values()->all();

        return [
            'needs_upgrade' => $organization->licence_key === null && count($projects) >= 1 && config('app.store.activated'),
            'projects' => $projects,
        ];
    }

    public static function header(Project $project): array
    {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'short_description' => $project->short_description,
            'is_public' => $project->is_public,
        ];
    }

    public static function show(Project $project): array
    {
        $description = $project->description ? Str::markdown($project->description, ['html_input' => 'strip']) : null;

        $projectResources = $project->projectResources()->get()
            ->map(fn (ProjectResource $projectResource) => self::dtoResource($projectResource));

        return [
            'projectId' => $project->id,
            'description' => $description,
            'project_resources' => $projectResources,
        ];
    }

    public static function edit(Project $project): array
    {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'short_description' => $project->short_description,
            'description' => $project->description,
            'is_public' => $project->is_public,
        ];
    }

    public static function dtoResource(ProjectResource $projectResource): array
    {
        return [
            'id' => $projectResource->id,
            'label' => $projectResource->label,
            'link' => $projectResource->link,
        ];
    }
}
