<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use App\Models\Tempat;
use App\Models\Laporan;
use App\Models\Sidang;
use Illuminate\Support\Facades\Auth;

class PembimbingLaporanSidangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pembimbing = Pembimbing::where('user_id', $user->id)->firstOrFail();

        $tempatIds = Tempat::where('kd_pembimbing', $pembimbing->kd_pembimbing)
            ->pluck('kd_tempat');

        $laporans = Laporan::with(['siswa', 'industri'])
            ->whereIn('kd_tempat', $tempatIds)
            ->orderBy('kd_laporan', 'desc')
            ->get();

        $sidangs = Sidang::with(['siswa', 'industri'])
            ->whereIn('kd_tempat', $tempatIds)
            ->orderBy('kd_sidang', 'desc')
            ->get();

        return view('pembimbing.laporan-sidang.index', compact('pembimbing', 'laporans', 'sidangs'));
    }
}
