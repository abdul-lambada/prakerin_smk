<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showAdminLoginForm()
    {
        return view('auth.login_admin');
    }

    public function showDudiLoginForm()
    {
        return view('auth.login_dudi');
    }

    public function showDudiRegisterForm()
    {
        return view('auth.register_dudi');
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

            if (in_array(Auth::user()->role, ['admin', 'pembimbing', 'dudi'], true)) {
                return redirect()->route('dashboard.index');
            }

            Auth::logout();
        }

        return back()->withErrors([
            'username' => 'Username atau password salah, atau role tidak diizinkan.',
        ])->onlyInput('username');
    }

    public function registerDudi(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'nullable|email|max:255|unique:users,email',
            'identitas' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'] ?? null,
            'identitas' => $data['identitas'] ?? null,
            'role' => 'dudi',
            'password' => $data['password'],
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard.index');
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
        $role = Auth::check() ? Auth::user()->role : null;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'siswa') {
            return redirect()->route('login.siswa');
        }

        if ($role === 'dudi') {
            return redirect()->route('login.dudi');
        }

        // default: admin & pembimbing atau role lain diarahkan ke login admin
        return redirect()->route('login.admin');
    }
}
