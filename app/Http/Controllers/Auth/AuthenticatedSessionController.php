<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $loginemail = auth()->guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if($loginemail) {
            return redirect('/dashboard');
        } else {
            return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors(['email'=>'These credentials do not match our records.']);
        }
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user =  Auth::guard('web')->user();
        Auth::guard('web')->logout();
        $paramLog = [
            'activity' => 'Logout',
            'type' => 'Logout'
        ];
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
