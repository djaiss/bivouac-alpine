<?php

namespace App\Http\Middleware;

use App\Models\Message;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMessage
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_string($request->route()->parameter('message'))) {
            $id = (int) $request->route()->parameter('message');
        } else {
            $id = $request->route()->parameter('message')->id;
        }

        try {
            $message = Message::where('project_id', $request->project->id)
                ->findOrFail($id);

            // adding the current message to the request object so we can
            // access it in the controller by using $request->message
            $request->merge(['message' => $message]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
