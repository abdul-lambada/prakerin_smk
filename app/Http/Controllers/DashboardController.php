<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Pembimbing;
use App\Models\Industri;
use App\Models\Tempat;
use App\Models\Absensi;
use App\Models\Jurnal;
use App\Models\Laporan;
use App\Models\Info;

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
        $stats = [
            'total_siswa'        => Siswa::count(),
            'total_pembimbing'   => Pembimbing::count(),
            'total_industri'     => Industri::count(),
            'total_tempat'       => Tempat::count(),
            'absensi_hari_ini'   => Absensi::whereDate('tanggal', now()->toDateString())->count(),
            'jurnal_hari_ini'    => Jurnal::whereDate('tanggal', now()->toDateString())->count(),
            'total_laporan'      => Laporan::count(),
            'total_info'         => Info::count(),
        ];

        // Data untuk grafik absensi 7 hari terakhir
        $startDate = now()->subDays(6)->startOfDay();
        $endDate   = now()->endOfDay();

        $absensiPerHari = Absensi::selectRaw('DATE(tanggal) as tgl, COUNT(*) as total')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get()
            ->keyBy('tgl');

        $chartLabels = [];
        $chartData   = [];

        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $key = $date->toDateString();
            $chartLabels[] = $date->format('d/m');
            $chartData[]   = isset($absensiPerHari[$key]) ? $absensiPerHari[$key]->total : 0;
        }

        $latestInfos = Info::orderBy('tanggal', 'desc')->limit(5)->get();

        return view('dashboard.admin', array_merge($stats, [
            'chart_labels' => $chartLabels,
            'chart_data'   => $chartData,
            'latest_infos' => $latestInfos,
        ]));
    }

    public function pembimbing()
    {
        $user = Auth::user();

        $pembimbing = Pembimbing::where('user_id', $user->id)->first();

        if (! $pembimbing) {
            abort(403, 'Akun pembimbing belum terhubung dengan data pembimbing.');
        }

        $total_siswa_bimbingan = Siswa::where('kd_pembimbing', $pembimbing->kd_pembimbing)->count();

        $tempatQuery   = Tempat::where('kd_pembimbing', $pembimbing->kd_pembimbing);
        $total_tempat  = $tempatQuery->count();
        $tempatIds     = $tempatQuery->pluck('kd_tempat');

        $today = now()->toDateString();

        $absensi_hari_ini = Absensi::whereIn('kd_tempat', $tempatIds)
            ->whereDate('tanggal', $today)
            ->count();

        $jurnal_hari_ini = Jurnal::whereIn('kd_tempat', $tempatIds)
            ->whereDate('tanggal', $today)
            ->count();

        $total_laporan = Laporan::whereIn('kd_tempat', $tempatIds)->count();

        $latest_infos = Info::orderBy('tanggal', 'desc')->limit(5)->get();

        return view('dashboard.pembimbing', [
            'total_siswa_bimbingan' => $total_siswa_bimbingan,
            'total_tempat'          => $total_tempat,
            'absensi_hari_ini'      => $absensi_hari_ini,
            'jurnal_hari_ini'       => $jurnal_hari_ini,
            'total_laporan'         => $total_laporan,
            'latest_infos'          => $latest_infos,
        ]);
    }

    public function siswa()
    {
        $user = Auth::user();

        $siswa = Siswa::where('user_id', $user->id)->first();

        if (! $siswa) {
            abort(403, 'Akun siswa belum terhubung dengan data siswa.');
        }

        $nis = $siswa->nis_siswa;

        $total_tempat_saya = Tempat::where('nis_siswa', $nis)->count();

        $today = now()->toDateString();

        $absensi_hari_ini_saya = Absensi::where('nis_siswa', $nis)
            ->whereDate('tanggal', $today)
            ->count();

        $jurnal_hari_ini_saya = Jurnal::where('nis_siswa', $nis)
            ->whereDate('tanggal', $today)
            ->count();

        $total_laporan_saya = Laporan::where('nis_siswa', $nis)->count();

        $latest_infos = Info::orderBy('tanggal', 'desc')->limit(5)->get();

        return view('dashboard.siswa', [
            'siswa'                  => $siswa,
            'total_tempat_saya'      => $total_tempat_saya,
            'absensi_hari_ini_saya'  => $absensi_hari_ini_saya,
            'jurnal_hari_ini_saya'   => $jurnal_hari_ini_saya,
            'total_laporan_saya'     => $total_laporan_saya,
            'latest_infos'           => $latest_infos,
        ]);
    }
}
