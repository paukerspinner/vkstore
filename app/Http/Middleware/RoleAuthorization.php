<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Facades\JWTAuth;
use \Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Closure;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(["message" => "Unauthenticated"], 401);
        }

        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }
        return response()->json([
            'message' => 'You are unauthorized to access this resource'
        ], 401);
    }
}
