<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showAdminLoginForm()
    {
        return view('auth.login_admin');
    }

    public function showSiswaLoginForm()
    {
        return view('auth.login_siswa');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            if (in_array(Auth::user()->role, ['admin', 'pembimbing'], true)) {
                return redirect()->route('dashboard.index');
            }

            Auth::logout();
        }

        return back()->withErrors([
            'username' => 'Username atau password salah, atau role tidak diizinkan.',
        ])->onlyInput('username');
    }

    public function loginSiswa(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'siswa') {
                return redirect()->route('dashboard.index');
            }

            Auth::logout();
        }

        return back()->withErrors([
            'username' => 'Username atau password salah, atau role tidak diizinkan.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.admin');
    }
}
