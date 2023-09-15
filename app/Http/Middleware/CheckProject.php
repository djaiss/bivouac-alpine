<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProject
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_string($request->route()->parameter('project'))) {
            $id = (int) $request->route()->parameter('project');
        } else {
            $id = $request->route()->parameter('project')->id;
        }

        try {
            $project = Project::where('organization_id', $request->user()->organization_id)
                ->findOrFail($id);

            if ($project->users()->where('user_id', $request->user()->id)->doesntExist() && ! $project->is_public) {
                throw new ModelNotFoundException;
            }

            // adding the current project to the request object so we can
            // access it in the controller by using $request->project
            $request->merge(['project' => $project]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
