<?php

namespace App\ViewModels\Settings;

use App\Models\Organization;
use App\Models\Role;

class SettingsRoleViewModel
{
    public static function index(Organization $organization): array
    {
        $roles = $organization->roles()
            ->get()
            ->map(fn (Role $role) => self::dto($role));

        return [
            'roles' => $roles,
        ];
    }

    public static function dto(Role $role): array
    {
        return [
            'id' => $role->id,
            'label' => $role->label,
            'position' => $role->position,
        ];
    }
}
