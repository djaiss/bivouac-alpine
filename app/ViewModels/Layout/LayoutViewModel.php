<?php

namespace App\ViewModels\Layout;

use App\Models\User;

class LayoutViewModel
{
    public static function data(User $user): array
    {
        return [
            'name' => $user->name,
            'avatar' => $user->avatar,
            'can_manage_settings' => ($user->permissions === User::ROLE_ADMINISTRATOR ||
                $user->permissions === User::ROLE_ACCOUNT_MANAGER),
            'organization' => $user->organization->name,
        ];
    }
}
