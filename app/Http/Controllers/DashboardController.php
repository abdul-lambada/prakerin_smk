<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\Pembimbing;
use App\Models\Industri;
use App\Models\Tempat;
use App\Models\Absensi;
use App\Models\Jurnal;
use App\Models\Laporan;
use App\Models\Info;
use App\Models\Bimbingan;
use App\Models\Nilai;
use App\Models\ChatDudiPembimbing;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        return match ($user->role) {
            'admin'      => redirect()->route('dashboard.admin'),
            'pembimbing' => redirect()->route('dashboard.pembimbing'),
            'siswa'      => redirect()->route('dashboard.siswa'),
            'dudi'       => redirect()->route('dashboard.dudi'),
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

        // Grafik PKL per tahun (berdasarkan tabel tempat)
        $pklPerTahun = Tempat::select('tahun', DB::raw('COUNT(*) as total'))
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $chartPklTahunLabels = $pklPerTahun->pluck('tahun');
        $chartPklTahunData   = $pklPerTahun->pluck('total');

        // Industri terfavorit (berdasarkan jumlah tempat)
        $industriFavorit = Industri::withCount('tempat')
            ->orderByDesc('tempat_count')
            ->limit(5)
            ->get();

        $chartIndustriLabels = $industriFavorit->pluck('nama_industri');
        $chartIndustriData   = $industriFavorit->pluck('tempat_count');

        // Tingkat kelulusan berdasarkan nilai akhir dan setting pkl_min_grade
        $pklMinGrade = (float) (Setting::get('pkl_min_grade') ?? 0);

        $totalLulus = Nilai::whereNotNull('nilai_akhir')
            ->where('nilai_akhir', '>=', $pklMinGrade)
            ->count();

        $totalTidakLulus = Nilai::whereNotNull('nilai_akhir')
            ->where('nilai_akhir', '<', $pklMinGrade)
            ->count();

        // Absensi per jurusan
        $absensiByJurusan = Absensi::with('siswa.kelas.jurusan')->get()
            ->groupBy(function ($item) {
                return optional(optional(optional($item->siswa)->kelas)->jurusan)->nama ?? 'Tidak diketahui';
            })
            ->map(function ($group) {
                return $group->count();
            });

        $chartAbsensiJurusanLabels = $absensiByJurusan->keys();
        $chartAbsensiJurusanData   = $absensiByJurusan->values();

        // Jurnal per jurusan
        $jurnalByJurusan = Jurnal::with('siswa.kelas.jurusan')->get()
            ->groupBy(function ($item) {
                return optional(optional(optional($item->siswa)->kelas)->jurusan)->nama ?? 'Tidak diketahui';
            })
            ->map(function ($group) {
                return $group->count();
            });

        $chartJurnalJurusanLabels = $jurnalByJurusan->keys();
        $chartJurnalJurusanData   = $jurnalByJurusan->values();

        $latestInfos = Info::orderBy('tanggal', 'desc')->limit(5)->get();

        return view('dashboard.admin', array_merge($stats, [
            'chart_labels'            => $chartLabels,
            'chart_data'              => $chartData,
            'chart_pkl_tahun_labels'  => $chartPklTahunLabels,
            'chart_pkl_tahun_data'    => $chartPklTahunData,
            'chart_industri_labels'   => $chartIndustriLabels,
            'chart_industri_data'     => $chartIndustriData,
            'total_lulus'             => $totalLulus,
            'total_tidak_lulus'       => $totalTidakLulus,
            'chart_absensi_jur_labels'=> $chartAbsensiJurusanLabels,
            'chart_absensi_jur_data'  => $chartAbsensiJurusanData,
            'chart_jurnal_jur_labels' => $chartJurnalJurusanLabels,
            'chart_jurnal_jur_data'   => $chartJurnalJurusanData,
            'latest_infos'            => $latestInfos,
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

        $unread_bimbingan = Bimbingan::whereIn('kd_tempat', $tempatIds)
            ->where('is_read_pembimbing', false)
            ->count();

        // Pesan chat dari DUDI yang belum dibaca pembimbing
        $unread_chat_dudi = ChatDudiPembimbing::where('to_user_id', $user->id)
            ->where('is_read_pembimbing', false)
            ->count();

        $latest_infos = Info::orderBy('tanggal', 'desc')->limit(5)->get();

        return view('dashboard.pembimbing', [
            'total_siswa_bimbingan' => $total_siswa_bimbingan,
            'total_tempat'          => $total_tempat,
            'absensi_hari_ini'      => $absensi_hari_ini,
            'jurnal_hari_ini'       => $jurnal_hari_ini,
            'total_laporan'         => $total_laporan,
            'unread_bimbingan'      => $unread_bimbingan,
            'unread_chat_dudi'      => $unread_chat_dudi,
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

        $unread_bimbingan_saya = Bimbingan::where('nis_siswa', $nis)
            ->where('is_read_siswa', false)
            ->whereNotNull('nip')
            ->count();

        $latest_infos = Info::orderBy('tanggal', 'desc')->limit(5)->get();

        return view('dashboard.siswa', [
            'siswa'                  => $siswa,
            'total_tempat_saya'      => $total_tempat_saya,
            'absensi_hari_ini_saya'  => $absensi_hari_ini_saya,
            'jurnal_hari_ini_saya'   => $jurnal_hari_ini_saya,
            'total_laporan_saya'     => $total_laporan_saya,
            'unread_bimbingan_saya'  => $unread_bimbingan_saya,
            'latest_infos'           => $latest_infos,
        ]);
    }

    public function dudi()
    {
        $user = Auth::user();

        // Cari industri yang terhubung ke akun DUDI ini (jika ada)
        $industri = Industri::where('user_id', $user->id)->first();

        $total_siswa_pkl      = 0;
        $total_nilai_du_di    = 0;
        $total_belum_dinilai  = 0;

        if ($industri) {
            $tempatQuery = Tempat::where('kd_industri', $industri->kd_industri);
            $total_siswa_pkl = $tempatQuery->count();

            $kdTempatList = $tempatQuery->pluck('kd_tempat');

            if ($kdTempatList->isNotEmpty()) {
                $total_nilai_du_di = Nilai::whereIn('kd_tempat', $kdTempatList)
                    ->whereNotNull('nilai_du_di')
                    ->count();
            }

            $total_belum_dinilai = max($total_siswa_pkl - $total_nilai_du_di, 0);
        }

        // Pesan chat dari pembimbing yang belum dibaca DUDI
        $unread_chat_pembimbing = ChatDudiPembimbing::where('to_user_id', $user->id)
            ->where('is_read_dudi', false)
            ->count();

        return view('dashboard.dudi', [
            'industri'             => $industri,
            'total_siswa_pkl'      => $total_siswa_pkl,
            'total_nilai_du_di'    => $total_nilai_du_di,
            'total_belum_dinilai'  => $total_belum_dinilai,
            'unread_chat_pembimbing' => $unread_chat_pembimbing,
        ]);
    }
}
