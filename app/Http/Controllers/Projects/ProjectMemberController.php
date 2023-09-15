<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Projects\ProjectViewModel;
use App\Models\Project;
use App\Models\User;
use App\Services\RemoveMemberFromProject;
use App\ViewModels\Projects\ProjectMemberViewModel;
use App\ViewModels\Projects\ProjectViewModel as ProjectsProjectViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

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

    public function destroy(Request $request, Project $project, User $member): JsonResponse
    {
        (new RemoveMemberFromProject)->execute([
            'user_id' => auth()->user()->id,
            'member_id' => $member->id,
            'project_id' => $project->id,
        ]);

        return response()->json([
            'data' => true,
        ], 200);
    }
}
