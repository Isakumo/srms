<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status !== 'ACTIVE') {
            Auth::logout();

            return redirect('/login')->withErrors([
                'username' => 'Your account is inactive or suspended.',
            ]);
        }

        return $next($request);
    }
}
