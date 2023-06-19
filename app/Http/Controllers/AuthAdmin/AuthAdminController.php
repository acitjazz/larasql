<?php

namespace App\Http\Controllers\AuthAdmin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AuthAdminController extends Controller
{
    /**
     * Display admin login view
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {


        return Inertia::render('Auth/Login', [
            'status' => session('status'),
        ]);
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $loginemail = auth()->guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if($loginemail) {
            return redirect()->route('backend.dashboard');
        } else {
            return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors(['email'=>'These credentials do not match our records.']);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login.create');
    }
}
