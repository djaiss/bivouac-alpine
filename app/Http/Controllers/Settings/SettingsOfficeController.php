<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Services\CreateOffice;
use App\Services\DestroyOffice;
use App\Services\UpdateOffice;
use App\ViewModels\Settings\SettingsOfficeViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsOfficeController extends Controller
{
    public function index(): View
    {
        $viewModel = SettingsOfficeViewModel::index(auth()->user()->organization);

        return view('settings.office.index', ['view' => $viewModel]);
    }

    public function create(): View
    {
        return view('settings.office.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_main_office' => 'nullable|string',
        ]);

        (new CreateOffice())->execute(
            name: $validated['name'],
            isMainOffice: $validated['is_main_office'] ?? false,
        );

        notify()->success(__('Office created successfully.'));

        return redirect()->route('settings.office.index');
    }

    public function edit(Office $office): View|RedirectResponse
    {
        if ($office->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.office.index'));
        }

        $viewModel = SettingsOfficeViewModel::dto($office);

        return view('settings.office.edit', ['view' => $viewModel]);
    }

    public function update(Request $request, Office $office): RedirectResponse
    {
        if ($office->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.office.index'));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_main_office' => 'nullable|string',
        ]);

        $office = (new UpdateOffice())->execute(
            office: $office,
            name: $validated['name'],
            isMainOffice: $validated['is_main_office'] ?? false
        );

        notify()->success(__('Changes saved.'));

        return redirect()->route('settings.office.index');
    }

    public function delete(Office $office): View|RedirectResponse
    {
        if ($office->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.office.index'));
        }

        $viewModel = SettingsOfficeViewModel::dto($office);

        return view('settings.office.destroy', ['view' => $viewModel]);
    }

    public function destroy(Office $office): RedirectResponse
    {
        if ($office->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('settings.office.index'));
        }

        (new DestroyOffice())->execute(
            office: $office,
        );

        notify()->success(__('The office has been deleted.'));

        return redirect()->route('settings.office.index');
    }
}
