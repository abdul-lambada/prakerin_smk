<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use App\Models\Tempat;
use App\Models\Absensi;
use App\Models\Jurnal;
use Illuminate\Support\Facades\Auth;

class PembimbingMonitoringController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pembimbing = Pembimbing::where('user_id', $user->id)->firstOrFail();

        $tempatIds = Tempat::where('kd_pembimbing', $pembimbing->kd_pembimbing)
            ->pluck('kd_tempat');

        $absensis = Absensi::with(['siswa', 'tempat'])
            ->whereIn('kd_tempat', $tempatIds)
            ->orderByDesc('tanggal')
            ->get();

        $jurnals = Jurnal::with(['siswa', 'tempat'])
            ->whereIn('kd_tempat', $tempatIds)
            ->orderByDesc('tanggal')
            ->get();

        return view('pembimbing.monitoring.index', compact('pembimbing', 'absensis', 'jurnals'));
    }
}
