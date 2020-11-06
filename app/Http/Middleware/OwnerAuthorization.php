<?php

namespace App\Http\Middleware;

use Closure;

class OwnerAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = $request->route()->parameter('userId');
        if (auth()->user()->role != 'admin' && $userId != auth()->user()->id) {
            return response()->json([
                'error' => 'Anauthorized action'
            ], 403);
        }
        return $next($request);
    }
}
