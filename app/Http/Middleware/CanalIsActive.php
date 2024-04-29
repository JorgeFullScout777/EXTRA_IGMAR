<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Channel;
use Inertia\Inertia;

class CanalIsActive
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
            $channel = Channel::find($request->route('id'));
            if (!$channel) {
                $Data=["Error"=>"Canal no encontrado", "Codigo"=>"404","url"=>" /channel/index"];
                return Inertia::render('error', ["Data"=>$Data]);
            }
            if (auth()->user()->role_id == 1){
                return $next($request);
            }
            if (!$channel->is_active){
                return redirect()->route('channel.index');
            }
        }
        return $next($request);
    }
}
