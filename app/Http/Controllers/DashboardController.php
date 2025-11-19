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
        return view('dashboard.pembimbing');
    }

    public function siswa()
    {
        return view('dashboard.siswa');
    }
}
