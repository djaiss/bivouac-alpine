<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\CreateProject;
use App\Services\DestroyProject;
use App\Services\RegenerateAvatar;
use App\Services\UpdateProject;
use App\ViewModels\Projects\ProjectViewModel;
use App\ViewModels\Users\UserViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserAvatarController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $user = (new RegenerateAvatar)->execute($request->user);

        notify()->success(__('Changes saved.'));

        return redirect()->route('user.edit', $user->id);
    }
}
