<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('crm.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('crm')->attempt($credentials)) {
            return redirect()->route('crm.dashboard');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function logout()
    {
        Auth::guard('crm')->logout();
        return redirect()->route('crm.login');
    }
}
