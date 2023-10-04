<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\CreateTaskList;
use App\Services\DestroyTaskList;
use App\Services\UpdateTaskList;
use App\ViewModels\Projects\ProjectTaskListViewModel;
use App\ViewModels\Projects\ProjectViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectTaskController extends Controller
{
    public function show(Request $request): View
    {
        return view('project.tasklist.task.show', [
            'header' => ProjectViewModel::header($request->project),
            'view' => ProjectTaskListViewModel::edit($request->taskList),
        ]);
    }
}
