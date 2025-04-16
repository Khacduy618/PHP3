<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
        $page_title = 'Đăng nhập';
        return view('auth.login', compact('page_title'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        // $request_form->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);

        // Check user role and redirect accordingly
        $user = $request->user(); // Or Auth::user()
        if ($user->role === 'admin') { // Assuming 'admin' is the role value
            // Redirect admin to admin dashboard
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        // Redirect other users to the homepage (or their intended destination)
        return redirect()->intended(route('home', absolute: false));
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
