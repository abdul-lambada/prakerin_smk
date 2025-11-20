<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\Info;
use App\Models\Setting;
use App\Models\Tempat;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $settings = [
            'app_name'      => Setting::get('app_name') ?? 'PKL SMK',
            'school_name'   => Setting::get('school_name') ?? 'SMK',
            'school_address'=> Setting::get('school_address') ?? '',
            'school_city'   => Setting::get('school_city') ?? '',
            'app_logo'      => Setting::get('app_logo'),
            'theme_color_primary' => Setting::get('theme_color_primary') ?? '#2563eb',
        ];

        $industries = Industri::withCount('tempat')
            ->orderBy('nama_industri', 'asc')
            ->limit(6)
            ->get();
        $infos      = Info::orderBy('created_at', 'desc')->limit(4)->get();

        return view('public.home', compact('settings', 'industries', 'infos'));
    }

    public function industri()
    {
        $settings = [
            'app_name'      => Setting::get('app_name') ?? 'PKL SMK',
            'school_name'   => Setting::get('school_name') ?? 'SMK',
            'app_logo'      => Setting::get('app_logo'),
            'theme_color_primary' => Setting::get('theme_color_primary') ?? '#2563eb',
        ];

        $industries = Industri::withCount('tempat')
            ->orderBy('nama_industri', 'asc')
            ->paginate(12);

        return view('public.industri', compact('settings', 'industries'));
    }

    public function info(Request $request)
    {
        $settings = [
            'app_name'      => Setting::get('app_name') ?? 'PKL SMK',
            'school_name'   => Setting::get('school_name') ?? 'SMK',
            'app_logo'      => Setting::get('app_logo'),
            'school_address'=> Setting::get('school_address') ?? '',
            'school_phone'  => Setting::get('school_phone') ?? '',
            'school_email'  => Setting::get('school_email') ?? '',
            'school_city'   => Setting::get('school_city') ?? '',
            'pkl_coordinator_name' => Setting::get('pkl_coordinator_name') ?? '',
            'pkl_coordinator_nip'  => Setting::get('pkl_coordinator_nip') ?? '',
            'theme_color_primary'  => Setting::get('theme_color_primary') ?? '#2563eb',
        ];

        $availableCategories = Info::whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $availableYears = Info::selectRaw('DISTINCT COALESCE(YEAR(tanggal), YEAR(created_at)) as year')
            ->whereRaw('COALESCE(tanggal, created_at) IS NOT NULL')
            ->orderByDesc('year')
            ->pluck('year');

        $infosQuery = Info::query();

        if ($request->filled('kategori')) {
            $infosQuery->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('tahun')) {
            $year = (int) $request->input('tahun');
            $infosQuery->where(function ($q) use ($year) {
                $q->whereYear('tanggal', $year)
                  ->orWhereYear('created_at', $year);
            });
        }

        if ($request->filled('q')) {
            $term = $request->input('q');
            $infosQuery->where(function ($q) use ($term) {
                $q->where('judul', 'like', "%{$term}%")
                  ->orWhere('isi', 'like', "%{$term}%");
            });
        }

        $infos = $infosQuery->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('public.info', compact('settings', 'infos', 'availableCategories', 'availableYears'));
    }

    public function about()
    {
        $settings = [
            'app_name'      => Setting::get('app_name') ?? 'PKL SMK',
            'school_name'   => Setting::get('school_name') ?? 'SMK',
            'app_logo'      => Setting::get('app_logo'),
            'theme_color_primary' => Setting::get('theme_color_primary') ?? '#2563eb',
        ];

        return view('public.about', compact('settings'));
    }

    public function contact()
    {
        $settings = [
            'app_name'      => Setting::get('app_name') ?? 'PKL SMK',
            'school_name'   => Setting::get('school_name') ?? 'SMK',
            'school_address'=> Setting::get('school_address') ?? '',
            'school_phone'  => Setting::get('school_phone') ?? '',
            'school_email'  => Setting::get('school_email') ?? '',
            'school_city'   => Setting::get('school_city') ?? '',
            'pkl_coordinator_name' => Setting::get('pkl_coordinator_name') ?? '',
            'pkl_coordinator_nip'  => Setting::get('pkl_coordinator_nip') ?? '',
            'app_logo'      => Setting::get('app_logo'),
            'theme_color_primary'  => Setting::get('theme_color_primary') ?? '#2563eb',
        ];

        return view('public.contact', compact('settings'));
    }

    public function showIndustry(Industri $industri)
    {
        $settings = [
            'app_name'      => Setting::get('app_name') ?? 'PKL SMK',
            'school_name'   => Setting::get('school_name') ?? 'SMK',
            'app_logo'      => Setting::get('app_logo'),
            'theme_color_primary'  => Setting::get('theme_color_primary') ?? '#2563eb',
        ];

        $industri->loadCount('tempat');
        $activeYear = Setting::get('active_pkl_year');
        $rekapPerJurusan = [];

        if ($activeYear) {
            $tempatList = Tempat::with(['siswa.kelas.jurusan'])
                ->where('kd_industri', $industri->kd_industri)
                ->where('tahun', $activeYear)
                ->get();

            foreach ($tempatList as $tempat) {
                $jurusanName = optional(optional(optional($tempat->siswa)->kelas)->jurusan)->nama_jurusan ?? 'Lainnya';

                if (! isset($rekapPerJurusan[$jurusanName])) {
                    $rekapPerJurusan[$jurusanName] = [
                        'active' => 0,
                        'done'   => 0,
                        'total'  => 0,
                    ];
                }

                $rekapPerJurusan[$jurusanName]['total']++;

                if ($tempat->status === 'aktif') {
                    $rekapPerJurusan[$jurusanName]['active']++;
                } else {
                    $rekapPerJurusan[$jurusanName]['done']++;
                }
            }
        }

        return view('public.industri-show', compact('settings', 'industri', 'activeYear', 'rekapPerJurusan'));
    }

    public function showInfo(Info $info)
    {
        $settings = [
            'app_name'      => Setting::get('app_name') ?? 'PKL SMK',
            'school_name'   => Setting::get('school_name') ?? 'SMK',
            'app_logo'      => Setting::get('app_logo'),
            'theme_color_primary'  => Setting::get('theme_color_primary') ?? '#2563eb',
        ];

        return view('public.info-show', compact('settings', 'info'));
    }
}
