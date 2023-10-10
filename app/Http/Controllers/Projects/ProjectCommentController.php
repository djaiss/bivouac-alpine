<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Services\DestroyCommentOfMessage;
use App\Services\UpdateCommentOfMessage;
use App\ViewModels\Projects\ProjectMessageCommentViewModel;
use App\ViewModels\Projects\ProjectViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectCommentController extends Controller
{
    public function edit(Request $request): View
    {
        return view('project.message.comment.edit', [
            'header' => ProjectViewModel::header($request->project),
            'view' => ProjectMessageCommentViewModel::edit($request->comment),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string|max:65535',
        ]);

        (new UpdateCommentOfMessage)->execute(
            comment: $request->comment,
            body: $validated['body'],
        );

        notify()->success(__('Changes saved'));

        return redirect()->route('project.message.show', [
            'project' => $request->project,
            'message' => $request->message,
        ]);
    }

    public function delete(Request $request): View
    {
        return view('project.message.comment.destroy', [
            'header' => ProjectViewModel::header($request->project),
            'view' => ProjectMessageCommentViewModel::delete($request->comment),
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        (new DestroyCommentOfMessage)->execute(
            comment: $request->comment,
        );

        notify()->success(__('The comment has been deleted.'));

        return redirect()->route('project.message.show', [
            'project' => $request->project,
            'message' => $request->message,
        ]);
    }
}
