<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\CreateProject;
use App\Services\DestroyProject;
use App\Services\UpdateProject;
use App\ViewModels\Projects\ProjectViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $viewModel = ProjectViewModel::index(auth()->user());

        return view('project.index', ['view' => $viewModel]);
    }

    public function create(): View
    {
        return view('project.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'nullable|string',
        ]);

        $project = (new CreateProject)->execute(
            name: $validated['title'],
            description: $validated['description'] ?? '',
            isPublic: $validated['is_public'] ?? false,
        );

        notify()->success(__('Project created successfully.'));

        return redirect()->route('project.show', $project->id);
    }

    public function show(Request $request, Project $project): View
    {
        return view('project.show', [
            'header' => ProjectViewModel::header($project),
            'view' => ProjectViewModel::show($project),
        ]);
    }

    public function edit(Request $request, Project $project): View
    {
        $viewModel = ProjectViewModel::edit($project);

        return view('project.edit', [
            'header' => ProjectViewModel::header($project),
            'view' => $viewModel,
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'is_public' => 'required|string',
        ]);

        $project = (new UpdateProject)->execute(
            project: $project,
            name: $validated['title'],
            description: $validated['description'] ?? null,
            shortDescription: $validated['short_description'] ?? null,
            isPublic: $validated['is_public'] == 'true' ? true : false,
        );

        notify()->success(__('Changes saved.'));

        return redirect()->route('project.edit', $project->id);
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        (new DestroyProject)->execute($project);

        notify()->success(__('Project successfully deleted.'));

        return redirect()->route('project.index');
    }
}
