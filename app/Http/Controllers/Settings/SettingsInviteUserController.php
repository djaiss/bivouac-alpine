<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ResendUserInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingsInviteUserController extends Controller
{
    public function store(Request $request, User $user): RedirectResponse
    {
        if ($user->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.user.index'));
        }

        (new ResendUserInvitation)->execute(
            user: $user
        );

        notify()->success(__('Invitation sent.'));

        return redirect()->route('settings.user.index');
    }
}
