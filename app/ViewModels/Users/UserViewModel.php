<?php

namespace App\ViewModels\Users;

use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\User;
use Illuminate\Support\Str;

class UserViewModel
{
    public static function header(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
        ];
    }

    public static function edit(User $user): array
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'born_at' => $user->born_at?->format('Y-m-d'),
            'age_preferences' => $user->age_preferences,
        ];
    }
}
