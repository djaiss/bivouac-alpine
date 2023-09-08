<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\CreateRole;
use App\Services\DestroyRole;
use App\Services\UpdateRole;
use App\ViewModels\Settings\SettingsRoleViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsRoleController extends Controller
{
    public function index(): View
    {
        $viewModel = SettingsRoleViewModel::index(auth()->user()->organization);

        return view('settings.role.index', ['view' => $viewModel]);
    }

    public function create(): View
    {
        return view('settings.role.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
        ]);

        (new CreateRole)->execute(
            label: $validated['label'],
        );

        notify()->success(__('Role created successfully.'));

        return redirect()->route('settings.role.index');
    }

    public function edit(Role $role): View|RedirectResponse
    {
        if ($role->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.role.index'));
        }

        $viewModel = SettingsRoleViewModel::dto($role);

        return view('settings.role.edit', ['view' => $viewModel]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        if ($role->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.role.index'));
        }

        $validated = $request->validate([
            'role' => $role,
            'label' => 'required|string|max:255',
        ]);

        $role = (new UpdateRole)->execute(
            role: $role,
            label: $validated['label'],
            position: $role->position,
        );

        notify()->success(__('Changes saved.'));

        return redirect()->route('settings.role.index');
    }

    public function delete(Role $role): View
    {
        if ($role->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.role.index'));
        }

        $viewModel = SettingsRoleViewModel::dto($role);

        return view('settings.role.destroy', ['view' => $viewModel]);
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.role.index'));
        }

        (new DestroyRole)->execute(
            role: $role,
        );

        notify()->success(__('The role has been deleted.'));

        return redirect()->route('settings.role.index');
    }
}
