<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Services\CreateMessage;
use App\Services\DestroyMessage;
use App\Services\UpdateMessage;
use App\ViewModels\Projects\ProjectMessageViewModel;
use App\ViewModels\Projects\ProjectViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectTaskListController extends Controller
{
    public function index(Request $request): View
    {
        $viewModel = ProjectMessageViewModel::index($request->project);

        return view('project.tasklist.index', [
            'header' => ProjectViewModel::header($request->project),
            'view' => $viewModel,
        ]);
    }
}
