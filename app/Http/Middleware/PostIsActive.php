<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Post;

class PostIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->route('id')) {
            $post = Post::find($request->route('id'));
            if (!$post) {
                return response()->json(['error' => 'post not found'], 404);
            }
            if (auth()->user()->role_id == 1){
                return $next($request);
            }
            if (!$post->is_active){
                return response()->json(['error' => 'post is not active'], 404);
            }
        }
        return $next($request);
    }
}
