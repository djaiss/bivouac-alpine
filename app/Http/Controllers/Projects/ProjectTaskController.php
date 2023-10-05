<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\ViewModels\Projects\ProjectTaskViewModel;
use App\ViewModels\Projects\ProjectViewModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectTaskController extends Controller
{
    public function show(Request $request): View
    {
        return view('project.tasklist.task.show', [
            'header' => ProjectViewModel::header($request->project),
            'view' => ProjectTaskViewModel::show($request->task),
        ]);
    }
}
