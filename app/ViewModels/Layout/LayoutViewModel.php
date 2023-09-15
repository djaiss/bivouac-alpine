<?php

namespace App\ViewModels\Layout;

use App\Models\User;
use Illuminate\Support\Facades\App;

class LayoutViewModel
{
    public static function data(User $user): array
    {
        $localesCollection = collect();
        $localesCollection->push([
            'name' => 'English',
            'shortCode' => 'en',
            'url' => route('locale.update', ['locale' => 'en']),
        ]);
        $localesCollection->push([
            'name' => 'Français',
            'shortCode' => 'fr',
            'url' => route('locale.update', ['locale' => 'fr']),
        ]);

        return [
            'current_locale' => App::currentLocale(),
            'locales' => $localesCollection,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'can_manage_settings' => ($user->permissions === User::ROLE_ADMINISTRATOR ||
                $user->permissions === User::ROLE_ACCOUNT_MANAGER),
            'organization' => $user->organization->name,
        ];
    }
}
