<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Services\CreateMessage;
use App\ViewModels\Projects\ProjectMessageViewModel;
use App\ViewModels\Projects\ProjectViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProjectMessageController extends Controller
{
    public function index(Request $request): View
    {
        $viewModel = ProjectMessageViewModel::index($request->project);

        return view('project.message.index', [
            'header' => ProjectViewModel::header($request->project),
            'view' => $viewModel,
        ]);
    }

    public function create(Request $request): View
    {
        return view('project.message.create', [
            'header' => ProjectViewModel::header($request->project),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:65535',
        ]);

        $message = (new CreateMessage)->execute(
            projectId: $request->project->id,
            title: $validated['title'] ?? '',
            body: $validated['body'] ?? '',
        );

        notify()->success(__('Message created successfully.'));

        return redirect()->route('project.message.show', [
            'project' => $request->project,
            'message' => $message,
        ]);
    }
}
