<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Services\CreateProjectResource;
use App\Services\DestroyCommentOfMessage;
use App\Services\DestroyProject;
use App\Services\DestroyProjectResource;
use App\Services\UpdateCommentOfMessage;
use App\Services\UpdateProjectResource;
use App\ViewModels\Projects\ProjectMessageCommentViewModel;
use App\ViewModels\Projects\ProjectResourceViewModel;
use App\ViewModels\Projects\ProjectViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectResourceController extends Controller
{
    public function index(Request $request): View
    {
        return view('project.resource.index', [
            'view' => ProjectResourceViewModel::index($request->project),
        ]);
    }

    public function create(Request $request): View
    {
        return view('project.resource.create', [
            'view' => ProjectResourceViewModel::create($request->project),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);

        (new CreateProjectResource)->execute(
            projectId: $request->project->id,
            label: $validated['label'],
            link: $validated['link'],
        );

        return view('project.resource.index', [
            'view' => ProjectResourceViewModel::index($request->project),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('project.resource.edit', [
            'view' => ProjectResourceViewModel::dto($request->projectResource),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);

        (new UpdateProjectResource)->execute(
            projectResource: $request->projectResource,
            label: $validated['label'],
            link: $validated['link'],
        );

        return view('project.resource.index', [
            'view' => ProjectResourceViewModel::index($request->project),
        ]);
    }

    public function destroy(Request $request)
    {
        (new DestroyProjectResource)->execute(
            projectResource: $request->projectResource,
        );

        return view('project.resource.index', [
            'view' => ProjectResourceViewModel::index($request->project),
        ]);
    }
}
