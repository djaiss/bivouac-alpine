<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckComment
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_string($request->route()->parameter('comment'))) {
            $id = (int) $request->route()->parameter('comment');
        } else {
            $id = $request->route()->parameter('comment')->id;
        }

        try {
            $comment = Comment::where('commentable_id', $request->message->id)
                ->findOrFail($id);

            // adding the current comment to the request object so we can
            // access it in the controller by using $request->comment
            $request->merge(['comment' => $comment]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
