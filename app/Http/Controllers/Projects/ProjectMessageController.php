<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Services\CreateMessage;
use App\Services\DestroyMessage;
use App\Services\MarkMessageAsRead;
use App\Services\UpdateMessage;
use App\ViewModels\Projects\ProjectMessageViewModel;
use App\ViewModels\Projects\ProjectViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        $message = (new CreateMessage())->execute(
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

    public function show(Request $request): View
    {
        (new MarkMessageAsRead())->execute(
            messageId: $request->message->id,
        );

        return view('project.message.show', [
            'header' => ProjectViewModel::header($request->project),
            'view' => ProjectMessageViewModel::show($request->message),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('project.message.edit', [
            'header' => ProjectViewModel::header($request->project),
            'view' => ProjectMessageViewModel::edit($request->message),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:65535',
        ]);

        $message = (new UpdateMessage())->execute(
            message: $request->message,
            title: $validated['title'],
            body: $validated['body'],
        );

        notify()->success(__('Changes saved'));

        return redirect()->route('project.message.show', [
            'project' => $request->project,
            'message' => $message,
        ]);
    }

    public function delete(Request $request): View
    {
        return view('project.message.destroy', [
            'header' => ProjectViewModel::header($request->project),
            'view' => ProjectMessageViewModel::delete($request->message),
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        (new DestroyMessage())->execute(
            message: $request->message,
        );

        notify()->success(__('The message has been deleted.'));

        return redirect()->route('project.message.index', [
            'project' => $request->project,
        ]);
    }
}
