<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();
        $user_role  = $user->hasRole->slug;
        switch ($user_role) {
            case 'super-admin':
                return redirect()->intended('/superadmin');
            case 'company-admin':
                return redirect()->intended('/admin/dashboard');
            case 'manager':
                return redirect()->intended('/manager/dashboard');
            case 'employee':
                return redirect()->intended('/employee/dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Unauthorized user type.'
                ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
