<?php

namespace App\Http\Controllers\Dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function show()
    {
        return view('dash.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email','min:6','max:255'],
            'password' => ['required','string'],
            'remember' => ['nullable']
        ]);


        if (Auth::guard('admin')->attempt(['email'=> $credentials['email'], 'password'=> $credentials['password']], isset($credentials['remember']))) {
            $request->session()->regenerate();

            return to_route('dash.home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('dash.login');
    }
}
