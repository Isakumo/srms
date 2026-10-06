<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (! Auth::check()) {
            abort(401);
        }

        if (! Auth::user()->hasPermission($permission)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
