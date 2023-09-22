<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_string($request->route()->parameter('user'))) {
            $id = (int) $request->route()->parameter('user');
        } else {
            $id = $request->route()->parameter('user')->id;
        }

        try {
            $user = User::where('organization_id', auth()->user()->organization_id)
                ->findOrFail($id);

            if (auth()->user()->id !== $user->id &&
                auth()->user()->permissions === User::ROLE_USER
            ) {
                abort(401);
            }

            // adding the current user to the request object so we can
            // access it in the controller by using $request->user
            $request->merge(['user' => $user]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
