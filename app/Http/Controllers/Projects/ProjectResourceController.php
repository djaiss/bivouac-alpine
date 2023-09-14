<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\CreateProject;
use App\Services\CreateProjectResource;
use App\Services\DestroyProject;
use App\Services\UpdateProject;
use App\ViewModels\Projects\ProjectViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectResourceController extends Controller
{
    public function edit(Request $request, Project $project): View
    {
        $viewModel = ProjectViewModel::edit($project);

        return view('project.edit', [
            'header' => ProjectViewModel::header($project),
            'view' => $viewModel,
        ]);
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        (new DestroyProject)->execute($project);

        notify()->success(__('Project successfully deleted.'));

        return redirect()->route('project.index');
    }
}
