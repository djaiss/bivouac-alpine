<?php

namespace App\Http\Middleware;

use App\Models\Message;
use App\Models\ProjectResource;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProjectResource
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_string($request->route()->parameter('resource'))) {
            $id = (int) $request->route()->parameter('resource');
        } else {
            $id = $request->route()->parameter('resource')->id;
        }

        try {
            $resource = ProjectResource::where('project_id', $request->project->id)
                ->findOrFail($id);

            // adding the current resource to the request object so we can
            // access it in the controller by using $request->projectResource
            $request->merge(['projectResource' => $resource]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
