<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use App\Models\Task;
use App\Models\TaskList;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTask
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_string($request->route()->parameter('task'))) {
            $id = (int) $request->route()->parameter('task');
        } else {
            $id = $request->route()->parameter('task')->id;
        }

        try {
            $task = Task::where('task_list_id', $request->taskList->id)
                ->findOrFail($id);

            // adding the current task to the request object so we can
            // access it in the controller by using $request->task
            $request->merge(['task' => $task]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
