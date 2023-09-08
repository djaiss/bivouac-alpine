<?php

namespace App\ViewModels\Settings;

use App\Models\Organization;

class SettingsOrganizationViewModel
{
    public static function index(Organization $organization): array
    {
        return [
            'name' => $organization->name,
        ];
    }
}
