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

class ProjectTaskListController extends Controller
{
    public function index(Request $request): View
    {
        $viewModel = ProjectTaskListViewModel::index($request->project);

        return view('project.tasklist.index', [
            'header' => ProjectViewModel::header($request->project),
            'view' => $viewModel,
        ]);
    }

    public function create(Request $request): View
    {
        return view('project.tasklist.create', [
            'header' => ProjectViewModel::header($request->project),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $taskList = (new CreateTaskList())->execute(
            name: $validated['title'] ?? '',
        );

        $taskList->project_id = $request->project->id;
        $taskList->tasklistable_id = $request->project->id;
        $taskList->tasklistable_type = Project::class;
        $taskList->save();

        notify()->success(__('Task list created successfully.'));

        return redirect()->route('project.tasklist.index', [
            'project' => $request->project,
        ]);
    }

    public function edit(Request $request): View
    {
        return view('project.tasklist.edit', [
            'header' => ProjectViewModel::header($request->project),
            'view' => ProjectTaskListViewModel::edit($request->taskList),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        (new UpdateTaskList())->execute(
            taskList: $request->taskList,
            name: $validated['title'],
        );

        notify()->success(__('Changes saved'));

        return redirect()->route('project.tasklist.index', [
            'project' => $request->project,
        ]);
    }

    public function delete(Request $request): View
    {
        return view('project.tasklist.destroy', [
            'header' => ProjectViewModel::header($request->project),
            'view' => ProjectTaskListViewModel::delete($request->taskList),
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        (new DestroyTaskList())->execute(
            taskList: $request->taskList,
        );

        notify()->success(__('Task list successfully deleted.'));

        return redirect()->route('project.tasklist.index', [
            'project' => $request->project,
        ]);
    }
}
