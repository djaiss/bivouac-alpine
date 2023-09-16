<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateProjectLastUpdatedAt;
use App\Models\Project;
use App\Models\User;
use App\ViewModels\Projects\ProjectMemberViewModel;
use App\ViewModels\Projects\ProjectViewModel as ProjectsProjectViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectMemberController extends Controller
{
    public function index(Request $request): View
    {
        $viewModel = ProjectMemberViewModel::index($request->project);

        return view('project.member.index', [
            'header' => ProjectsProjectViewModel::header($request->project),
            'view' => $viewModel,
        ]);
    }

    public function delete(Request $request, int $projectId, User $user): View|RedirectResponse
    {
        if ($user->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('project.index'));
        }

        $viewModel = ProjectMemberViewModel::delete($user);

        return view('project.member.destroy', [
            'header' => ProjectsProjectViewModel::header($request->project),
            'view' => $viewModel,
        ]);
    }

    public function destroy(Request $request, Project $project, User $user): RedirectResponse
    {
        if ($user->organization_id !== auth()->user()->organization_id) {
            return redirect()->to(route('project.index'));
        }

        $user->projects()->detach($project);

        UpdateProjectLastUpdatedAt::dispatch($project->id);

        notify()->success(__('Member has been removed from the project.'));

        return redirect()->route('project.member.index', $project->id);
    }
}
