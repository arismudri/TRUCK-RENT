<?php

namespace App\Http\Middleware;

use Closure;

class AuthKey
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
        $token = $request->APP_KEY;
        if($token != 'QWERTY') {
            // return response()->json($request, 401);
            return response()->json(['message' => 'APP_KEY not found'], 401);
        }
        return $next($request);
    }
}
