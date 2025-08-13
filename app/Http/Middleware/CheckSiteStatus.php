<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSiteStatus
{
    public function handle(Request $request, Closure $next)
    {
        $mode = env('APP_SITE_MODE', 'down');
        $currentPath = $request->path();

        if ($mode === 'up' && $currentPath === 'maintenance') {
            return redirect('/');
        }

        if ($mode !== 'up') {
            if ($currentPath === 'maintenance') {
                return $next($request);
            }

            if ($request->is('api/*')) {
                return ApiResponse('The site is under maintenance.', 'error', 503);
            }

            if (Auth::check()) {
                Auth::logout();
            }

            return redirect()->route('maintenance');
        }

        return $next($request);
    }
}
