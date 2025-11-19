<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pembimbing;
use Illuminate\Support\Facades\Auth;

class PembimbingSiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pembimbing = Pembimbing::where('user_id', $user->id)->firstOrFail();

        $siswa = Siswa::with(['kelas.jurusan'])
            ->where('kd_pembimbing', $pembimbing->kd_pembimbing)
            ->orderBy('nama_lengkap')
            ->get();

        return view('pembimbing.siswa.index', compact('siswa', 'pembimbing'));
    }
}
