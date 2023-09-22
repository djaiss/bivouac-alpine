<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\RegenerateAvatar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserAvatarController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $user = (new RegenerateAvatar)->execute($request->user);

        notify()->success(__('Changes saved.'));

        return redirect()->route('user.edit', $user->id);
    }
}
