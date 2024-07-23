<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        // Check if the authenticated user has the specified permission
        if (!$request->user()->hasPermissionTo($permission)) {
            return response()->json(['error' => 'No permission'], 403);
        }

        return $next($request);
    }
}
