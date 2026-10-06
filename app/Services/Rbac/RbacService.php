<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSchoolScope
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            abort(401);
        }

        $schoolId = $request->route('school') ?? $request->query('school_id');

        if ($schoolId !== null && ! Auth::user()->hasSchoolAccess((int) $schoolId)) {
            abort(403, 'You do not have access to this school.');
        }

        return $next($request);
    }
}
