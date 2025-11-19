<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tempat;
use Illuminate\Support\Facades\Auth;

class SiswaTempatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $tempats = Tempat::with(['industri', 'pembimbing.user'])
            ->where('nis_siswa', $siswa->nis_siswa)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa.tempat.index', compact('siswa', 'tempats'));
    }
}
