<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Tempat;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $nilais = Nilai::with('tempat.siswa')->get();
        return view('admin.nilai.index', compact('nilais'));
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
