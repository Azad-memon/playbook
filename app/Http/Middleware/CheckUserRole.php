<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        if ($user && $user->hasRole->slug == $role) {
            return $next($request);

        }
        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Unauthorized access.']);

    }
}
