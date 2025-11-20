<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Tempat;
use App\Models\Setting;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Industri;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'jurusan' => $request->query('jurusan'),
            'kelas' => $request->query('kelas'),
            'tahun' => $request->query('tahun'),
            'industri' => $request->query('industri'),
        ];

        $query = Nilai::with(['tempat.siswa.kelas.jurusan', 'tempat.industri']);

        if ($filters['jurusan']) {
            $query->whereHas('tempat.siswa.kelas.jurusan', function ($q) use ($filters) {
                $q->where('kd_jurusan', $filters['jurusan']);
            });
        }

        if ($filters['kelas']) {
            $query->whereHas('tempat.siswa.kelas', function ($q) use ($filters) {
                $q->where('kd_kelas', $filters['kelas']);
            });
        }

        if ($filters['tahun']) {
            $query->whereHas('tempat', function ($q) use ($filters) {
                $q->where('tahun', $filters['tahun']);
            });
        }

        if ($filters['industri']) {
            $query->whereHas('tempat.industri', function ($q) use ($filters) {
                $q->where('kd_industri', $filters['industri']);
            });
        }

        $nilais = $query->get();

        $rekap = [
            'total' => $nilais->count(),
            'rata_nilai_akhir' => round((float) $nilais->avg('nilai_akhir'), 2),
        ];

        $rekapPerJurusan = $nilais
            ->groupBy(function ($item) {
                return optional(optional(optional($item->tempat)->siswa)->kelas)->jurusan->nama ?? 'Tidak diketahui';
            })
            ->map(function ($group) {
                return [
                    'jumlah' => $group->count(),
                    'rata_nilai_akhir' => round((float) $group->avg('nilai_akhir'), 2),
                ];
            });

        $rekapPerTahun = $nilais
            ->groupBy(function ($item) {
                return optional($item->tempat)->tahun ?? 'Tidak diketahui';
            })
            ->map(function ($group) {
                return [
                    'jumlah' => $group->count(),
                    'rata_nilai_akhir' => round((float) $group->avg('nilai_akhir'), 2),
                ];
            });

        // Rekap per industri: total, lulus, tidak lulus (berdasarkan nilai_akhir >= pkl_min_grade jika di-set)
        $pklMinGrade = (float) (Setting::get('pkl_min_grade') ?? 0);

        $rekapPerIndustri = $nilais
            ->groupBy(function ($item) {
                return optional(optional($item->tempat)->industri)->nama_industri ?? 'Tidak diketahui';
            })
            ->map(function ($group) use ($pklMinGrade) {
                $total = $group->count();
                $lulus = $group->filter(function ($n) use ($pklMinGrade) {
                    return $n->nilai_akhir !== null && $n->nilai_akhir >= $pklMinGrade;
                })->count();
                $tidakLulus = $total - $lulus;

                return [
                    'total' => $total,
                    'lulus' => $lulus,
                    'tidak_lulus' => $tidakLulus,
                ];
            });

        $jurusans = Jurusan::orderBy('nama')->get();
        $kelasList = Kelas::orderBy('nama')->get();
        $industris = Industri::orderBy('nama_industri')->get();
        $tahunList = Tempat::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('admin.nilai.index', compact(
            'nilais',
            'filters',
            'rekap',
            'rekapPerJurusan',
            'rekapPerTahun',
            'rekapPerIndustri',
            'jurusans',
            'kelasList',
            'industris',
            'tahunList'
        ));
    }

    public function create()
    {
        $tempats = Tempat::with('siswa')->get();
        return view('admin.nilai.create', compact('tempats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kd_tempat'   => 'required|exists:tbl_tempat,kd_tempat',
            'nilai_du_di' => 'nullable|numeric|min:0|max:100',
            'nilai_sidang'=> 'nullable|numeric|min:0|max:100',
            'bobot_du_di' => 'required|integer|min:0|max:100',
            'bobot_sidang'=> 'required|integer|min:0|max:100',
            'keterangan'  => 'nullable|string|max:50',
        ]);

        if (($data['bobot_du_di'] + $data['bobot_sidang']) !== 100) {
            return back()
                ->withErrors(['bobot_du_di' => 'Jumlah bobot DU/DI dan Sidang harus 100%.'])
                ->withInput();
        }

        $this->hitungNilaiAkhirDanPredikat($data);

        Nilai::create($data);

        return redirect()->route('admin.nilai.index')->with('status', 'Nilai PKL berhasil ditambahkan.');
    }

    public function edit(Nilai $nilai)
    {
        $tempats = Tempat::with('siswa')->get();
        return view('admin.nilai.edit', compact('nilai', 'tempats'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $data = $request->validate([
            'kd_tempat'   => 'required|exists:tbl_tempat,kd_tempat',
            'nilai_du_di' => 'nullable|numeric|min:0|max:100',
            'nilai_sidang'=> 'nullable|numeric|min:0|max:100',
            'bobot_du_di' => 'required|integer|min:0|max:100',
            'bobot_sidang'=> 'required|integer|min:0|max:100',
            'keterangan'  => 'nullable|string|max:50',
        ]);

        if (($data['bobot_du_di'] + $data['bobot_sidang']) !== 100) {
            return back()
                ->withErrors(['bobot_du_di' => 'Jumlah bobot DU/DI dan Sidang harus 100%.'])
                ->withInput();
        }

        // Kunci nilai DU/DI: jika sudah ada di database (diisi DUDI),
        // jangan izinkan perubahan lewat form admin.
        if ($nilai->nilai_du_di !== null) {
            $data['nilai_du_di'] = $nilai->nilai_du_di;
        }

        $this->hitungNilaiAkhirDanPredikat($data);

        $nilai->update($data);

        return redirect()->route('admin.nilai.index')->with('status', 'Nilai PKL berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()->route('admin.nilai.index')->with('status', 'Nilai PKL berhasil dihapus.');
    }

    public function exportCsv(Request $request)
    {
        // Gunakan logika filter yang sama dengan index
        $filters = [
            'jurusan' => $request->query('jurusan'),
            'kelas' => $request->query('kelas'),
            'tahun' => $request->query('tahun'),
            'industri' => $request->query('industri'),
        ];

        $query = Nilai::with(['tempat.siswa.kelas.jurusan', 'tempat.industri']);

        if ($filters['jurusan']) {
            $query->whereHas('tempat.siswa.kelas.jurusan', function ($q) use ($filters) {
                $q->where('kd_jurusan', $filters['jurusan']);
            });
        }

        if ($filters['kelas']) {
            $query->whereHas('tempat.siswa.kelas', function ($q) use ($filters) {
                $q->where('kd_kelas', $filters['kelas']);
            });
        }

        if ($filters['tahun']) {
            $query->whereHas('tempat', function ($q) use ($filters) {
                $q->where('tahun', $filters['tahun']);
            });
        }

        if ($filters['industri']) {
            $query->whereHas('tempat.industri', function ($q) use ($filters) {
                $q->where('kd_industri', $filters['industri']);
            });
        }

        $nilais = $query->get();

        $filename = 'nilai-pkl-'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($nilais) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Tempat / Industri',
                'Nama Siswa',
                'Jurusan',
                'Kelas',
                'Tahun PKL',
                'Nilai DU/DI',
                'Nilai Sidang',
                'Bobot DU/DI',
                'Bobot Sidang',
                'Nilai Akhir',
                'Predikat',
                'Keterangan',
            ]);

            foreach ($nilais as $item) {
                $siswa = optional(optional($item->tempat)->siswa);
                $kelas = optional($siswa->kelas);
                $jurusan = optional($kelas->jurusan);
                $industri = optional(optional($item->tempat)->industri);

                fputcsv($handle, [
                    $industri->nama_industri,
                    $siswa->nama_lengkap,
                    $jurusan->nama,
                    $kelas->nama,
                    optional($item->tempat)->tahun,
                    $item->nilai_du_di,
                    $item->nilai_sidang,
                    $item->bobot_du_di,
                    $item->bobot_sidang,
                    $item->nilai_akhir,
                    $item->predikat,
                    $item->keterangan,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function cetakPdf()
    {
        $nilais = Nilai::with('tempat.siswa')->get();

        $schoolName = Setting::get('school_name') ?? 'SMK';
        $appName = Setting::get('app_name', 'PKL SMK');
        $activeAcademicYear = Setting::get('active_academic_year');
        $activePklYear = Setting::get('active_pkl_year');

        $pdf = Pdf::loadView('admin.nilai.pdf', [
            'nilais' => $nilais,
            'schoolName' => $schoolName,
            'appName' => $appName,
            'activeAcademicYear' => $activeAcademicYear,
            'activePklYear' => $activePklYear,
        ])->setPaper('A4', 'landscape');

        return $pdf->download('nilai-pkl-'.date('Ymd').'.pdf');
    }

    private function hitungNilaiAkhirDanPredikat(array &$data): void
    {
        $nilaiDuDi   = $data['nilai_du_di']   ?? null;
        $nilaiSidang = $data['nilai_sidang'] ?? null;

        if ($nilaiDuDi !== null && $nilaiSidang !== null) {
            $akhir = round(
                ($nilaiDuDi   * $data['bobot_du_di']   / 100) +
                ($nilaiSidang * $data['bobot_sidang'] / 100),
                2
            );
            $data['nilai_akhir'] = $akhir;
            $data['predikat']    = $this->predikatDariNilai($akhir);
            // sinkronkan kolom lama "nilai" sebagai total
            $data['nilai']       = $akhir;
        } else {
            $data['nilai_akhir'] = null;
            $data['predikat']    = null;
            $data['nilai']       = $data['nilai_du_di'] ?? $data['nilai_sidang'] ?? null;
        }
    }

    private function predikatDariNilai(float $nilai): string
    {
        if ($nilai >= 85) {
            return 'A';
        }
        if ($nilai >= 75) {
            return 'B';
        }
        if ($nilai >= 65) {
            return 'C';
        }
        return 'D';
    }
}
