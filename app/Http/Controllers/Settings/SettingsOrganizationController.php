<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\DestroyOrganization;
use App\Services\UpdateOrganization;
use App\ViewModels\Settings\SettingsOrganizationViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsOrganizationController extends Controller
{
    public function index(): View
    {
        $viewModel = SettingsOrganizationViewModel::index(auth()->user()->organization);

        return view('settings.organization.index', ['view' => $viewModel]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
        ]);

        (new UpdateOrganization())->execute(
            name: $validated['label']
        );

        notify()->success(__('Changes saved.'));

        return redirect()->route('settings.organization.index');
    }

    public function delete(): View
    {
        $viewModel = SettingsOrganizationViewModel::index(auth()->user()->organization);

        return view('settings.organization.destroy', ['view' => $viewModel]);
    }

    public function destroy(): RedirectResponse
    {
        (new DestroyOrganization())->execute();

        return redirect()->route('login');
    }
}
