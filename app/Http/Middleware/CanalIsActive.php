<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Channel;

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
                return response()->json(['error' => 'channel not found'], 404);
            }
            if (auth()->user()->role_id == 1){
                return $next($request);
            }
            if (!$channel->is_active){
                return response()->json(['error' => 'channel is not active'], 404);
            }
        }
        return $next($request);
    }
}
