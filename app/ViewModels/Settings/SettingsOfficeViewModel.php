<?php

namespace App\ViewModels\Settings;

use App\Models\Office;
use App\Models\Organization;

class SettingsOfficeViewModel
{
    public static function index(Organization $organization): array
    {
        $offices = $organization->offices()
            ->get()
            ->map(fn (Office $office) => self::dto($office));

        return [
            'offices' => $offices,
        ];
    }

    public static function dto(Office $office): array
    {
        return [
            'id' => $office->id,
            'name' => $office->name,
            'is_main_office' => $office->is_main_office,
        ];
    }
}
