<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPAT
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        
        if (!$token || !auth()->guard('sanctum')->check()) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        return $next($request);
    }
}
