<?php

namespace App\Http\Middleware;

use App\Models\TaskList;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTaskList
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_string($request->route()->parameter('tasklist'))) {
            $id = (int) $request->route()->parameter('tasklist');
        } else {
            $id = $request->route()->parameter('tasklist')->id;
        }

        try {
            $taskList = TaskList::where('project_id', $request->project->id)
                ->findOrFail($id);

            // adding the current task list to the request object so we can
            // access it in the controller by using $request->taskList
            $request->merge(['taskList' => $taskList]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
