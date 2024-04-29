<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;

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
                $Data=["Error"=>"Post no encontrado", "Codigo"=>"404","url"=>"/channel/index"];
                return Inertia::render('error', ["Data"=>$Data]);
            }
            if (auth()->user()->role_id == 1){
                return $next($request);
            }
            if (!$post->is_active){
                return route('channel.index');
            }
        }
        return $next($request);
    }
}
