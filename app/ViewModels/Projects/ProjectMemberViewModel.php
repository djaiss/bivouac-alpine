<?php

namespace App\ViewModels\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

class ProjectMemberViewModel
{
    public static function index(Project $project): array
    {
        $members = $project->users()
            ->orderBy('last_name')
            ->get()
            ->map(fn (User $user) => self::dto($user, $project));

        return [
            'project_id' => $project->id,
            'members' => $members,
        ];
    }

    public static function delete(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
        ];
    }

    public static function dto(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
        ];
    }

    /**
     * List all the users who are not part of the project yet.
     */
    public static function listUsers(User $user, Project $project): Collection
    {
        $users = User::where('id', '!=', $user->id)
            ->whereNotIn('id', $project->users()->pluck('id'))
            ->where('organization_id', $user->organization_id)
            ->get()
            ->map(fn (User $user) => self::dto($user));

        return $users;
    }
}
