<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Tempat;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'jurusan' => $request->query('jurusan'),
            'kelas'   => $request->query('kelas'),
            'tahun'   => $request->query('tahun'),
        ];

        $query = Absensi::with(['siswa.kelas.jurusan', 'tempat.industri']);

        if ($filters['jurusan']) {
            $query->whereHas('siswa.kelas.jurusan', function ($q) use ($filters) {
                $q->where('kd_jurusan', $filters['jurusan']);
            });
        }

        if ($filters['kelas']) {
            $query->whereHas('siswa.kelas', function ($q) use ($filters) {
                $q->where('kd_kelas', $filters['kelas']);
            });
        }

        if ($filters['tahun']) {
            $query->whereHas('tempat', function ($q) use ($filters) {
                $q->where('tahun', $filters['tahun']);
            });
        }

        $absensis = $query->get();

        $jurusans = Jurusan::orderBy('nama')->get();
        $kelasList = Kelas::orderBy('nama')->get();
        $tahunList = Tempat::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('admin.absensi.index', compact('absensis', 'filters', 'jurusans', 'kelasList', 'tahunList'));
    }

    public function create()
    {
        $siswas  = Siswa::all();
        $tempats = Tempat::all();
        return view('admin.absensi.create', compact('siswas', 'tempats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis_siswa'  => 'required|exists:tbl_siswa,nis_siswa',
            'kd_tempat'  => 'required|exists:tbl_tempat,kd_tempat',
            'tanggal'    => 'required|date',
            'jam_masuk'  => 'required|string|max:10',
            'jam_keluar' => 'nullable|string|max:10',
            'status'     => 'required|string|max:20',
            'keterangan' => 'nullable|string|max:100',
            'foto'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('absensi', 'public');
        }

        Absensi::create($data);

        return redirect()->route('admin.absensi.index')->with('status', 'Data absensi berhasil ditambahkan.');
    }

    public function edit(Absensi $absensi)
    {
        $siswas  = Siswa::all();
        $tempats = Tempat::all();
        return view('admin.absensi.edit', compact('absensi', 'siswas', 'tempats'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $data = $request->validate([
            'nis_siswa'  => 'required|exists:tbl_siswa,nis_siswa',
            'kd_tempat'  => 'required|exists:tbl_tempat,kd_tempat',
            'tanggal'    => 'required|date',
            'jam_masuk'  => 'required|string|max:10',
            'jam_keluar' => 'nullable|string|max:10',
            'status'     => 'required|string|max:20',
            'keterangan' => 'nullable|string|max:100',
            'foto'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($absensi->foto && Storage::disk('public')->exists($absensi->foto)) {
                Storage::disk('public')->delete($absensi->foto);
            }

            $data['foto'] = $request->file('foto')->store('absensi', 'public');
        }

        $absensi->update($data);

        return redirect()->route('admin.absensi.index')->with('status', 'Data absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi)
    {
        if ($absensi->foto && Storage::disk('public')->exists($absensi->foto)) {
            Storage::disk('public')->delete($absensi->foto);
        }

        $absensi->delete();

        return redirect()->route('admin.absensi.index')->with('status', 'Data absensi berhasil dihapus.');
    }

    public function exportCsv(Request $request)
    {
        $filters = [
            'jurusan' => $request->query('jurusan'),
            'kelas'   => $request->query('kelas'),
            'tahun'   => $request->query('tahun'),
        ];

        $query = Absensi::with(['siswa.kelas.jurusan', 'tempat.industri']);

        if ($filters['jurusan']) {
            $query->whereHas('siswa.kelas.jurusan', function ($q) use ($filters) {
                $q->where('kd_jurusan', $filters['jurusan']);
            });
        }

        if ($filters['kelas']) {
            $query->whereHas('siswa.kelas', function ($q) use ($filters) {
                $q->where('kd_kelas', $filters['kelas']);
            });
        }

        if ($filters['tahun']) {
            $query->whereHas('tempat', function ($q) use ($filters) {
                $q->where('tahun', $filters['tahun']);
            });
        }

        $absensis = $query->get();

        $filename = 'absensi-pkl-'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($absensis) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Tanggal',
                'Nama Siswa',
                'Industri / Tempat',
                'Jam Masuk',
                'Jam Keluar',
                'Status',
                'Keterangan',
            ]);

            foreach ($absensis as $item) {
                $siswa = optional($item->siswa);
                $tempat = optional($item->tempat);
                $industri = optional($tempat->industri);

                fputcsv($handle, [
                    optional($item->tanggal)->format('Y-m-d'),
                    $siswa->nama_lengkap,
                    $industri->nama_industri ?: $tempat->kd_tempat,
                    $item->jam_masuk,
                    $item->jam_keluar,
                    $item->status,
                    $item->keterangan,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
