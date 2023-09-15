<?php

namespace App\Http\Controllers\Settings;

use App\Exceptions\CantDeleteHimselfException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\DestroyUser;
use App\Services\InviteUser;
use App\Services\UpdateUserPermission;
use App\ViewModels\Settings\SettingsUserViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsUserController extends Controller
{
    public function index(): View
    {
        $viewModel = SettingsUserViewModel::index(auth()->user());

        return view('settings.user.index', ['view' => $viewModel]);
    }

    public function create(): View
    {
        return view('settings.user.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255|unique:' . User::class,
        ]);

        (new InviteUser)->execute(
            email: $validated['email']
        );

        notify()->success(__('User invited successfully.'));

        return redirect()->route('settings.user.index');
    }

    public function edit(User $user): View|RedirectResponse
    {
        if ($user->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.user.index'));
        }

        $viewModel = SettingsUserViewModel::edit($user);

        return view('settings.user.edit', ['view' => $viewModel]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.user.index'));
        }

        $validated = $request->validate([
            'permissions' => 'required|string|max:255',
        ]);

        (new UpdateUserPermission)->execute(
            user: $user,
            permissions: $validated['permissions']
        );

        notify()->success(__('Changes saved.'));

        return redirect()->route('settings.user.index');
    }

    public function delete(User $user): View|RedirectResponse
    {
        if ($user->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.user.index'));
        }

        $viewModel = SettingsUserViewModel::delete($user);

        return view('settings.user.destroy', ['view' => $viewModel]);
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.user.index'));
        }

        try {
            (new DestroyUser)->execute(
                user: $user
            );
        } catch (CantDeleteHimselfException) {
            notify()->error(__('You can\'t delete yourself.'));

            return redirect()->route('settings.user.index');
        }

        notify()->success(__('The user has been deleted.'));

        return redirect()->route('settings.user.index');
    }
}
