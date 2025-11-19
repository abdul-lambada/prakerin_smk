<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class SiswaBimbinganController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $bimbingans = Bimbingan::with('tempat.industri')
            ->where('nis_siswa', $siswa->nis_siswa)
            ->orderByDesc('tanggal')
            ->get();

        return view('siswa.bimbingan.index', compact('siswa', 'bimbingans'));
    }
}
