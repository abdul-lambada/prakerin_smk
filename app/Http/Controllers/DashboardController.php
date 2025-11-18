<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login.admin');
        }

        return match ($user->role) {
            'admin'      => redirect()->route('dashboard.admin'),
            'pembimbing' => redirect()->route('dashboard.pembimbing'),
            'siswa'      => redirect()->route('dashboard.siswa'),
            default      => abort(403, 'Role tidak dikenali'),
        };
    }

    public function admin()
    {
        return view('dashboard.admin');
    }

    public function pembimbing()
    {
        return view('dashboard.pembimbing');
    }

    public function siswa()
    {
        return view('dashboard.siswa');
    }
}
