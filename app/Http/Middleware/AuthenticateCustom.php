<?php

namespace App\Http\Middleware;

use Closure;
use \App\Services\JWTSimple;

class AuthenticateCustom
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
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json('No token provided', 401);
        }

        $jwt = app(JWTSimple::class);

        if (!$jwt->validade($token)) {
            return response()->json('Invalid signature', 401);
        }

        return $next($request);
    }
}
