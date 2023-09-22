<?php

namespace App\ViewModels\Users;

use App\Models\User;

class UserViewModel
{
    public static function header(User $authenticatedUser, User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'can_see_settings' => $authenticatedUser->id === $user->id || $authenticatedUser->permissions !== User::ROLE_USER,
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
