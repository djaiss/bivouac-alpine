<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\UpdateUserInformation;
use App\ViewModels\Users\UserViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function edit(Request $request): View
    {
        return view('user.edit', [
            'header' => UserViewModel::header(auth()->user(), $request->user),
            'view' => UserViewModel::edit($request->user),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user = (new UpdateUserInformation())->execute(
            user: $request->user,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            email: $validated['email'],
        );

        notify()->success(__('Changes saved.'));

        return redirect()->route('user.edit', $user->id);
    }
}
