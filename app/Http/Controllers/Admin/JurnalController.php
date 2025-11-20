<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\Siswa;
use App\Models\Tempat;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'jurusan' => $request->query('jurusan'),
            'kelas'   => $request->query('kelas'),
            'tahun'   => $request->query('tahun'),
        ];

        $query = Jurnal::with(['siswa.kelas.jurusan', 'tempat.industri']);

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

        $jurnals = $query->get();

        $jurusans = Jurusan::orderBy('nama')->get();
        $kelasList = Kelas::orderBy('nama')->get();
        $tahunList = Tempat::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('admin.jurnal.index', compact('jurnals', 'filters', 'jurusans', 'kelasList', 'tahunList'));
    }

    public function create()
    {
        $siswas  = Siswa::all();
        $tempats = Tempat::all();
        return view('admin.jurnal.create', compact('siswas', 'tempats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis_siswa'  => 'required|exists:tbl_siswa,nis_siswa',
            'kd_tempat'  => 'required|exists:tbl_tempat,kd_tempat',
            'tanggal'    => 'required|date',
            'jam_mulai'  => 'required|string|max:10',
            'jam_selesai'=> 'nullable|string|max:10',
            'kegiatan'   => 'required|string|max:100',
            'deskripsi'  => 'nullable|string',
        ]);

        Jurnal::create($data);

        return redirect()->route('admin.jurnal.index')->with('status', 'Data jurnal berhasil ditambahkan.');
    }

    public function edit(Jurnal $jurnal)
    {
        $siswas  = Siswa::all();
        $tempats = Tempat::all();
        return view('admin.jurnal.edit', compact('jurnal', 'siswas', 'tempats'));
    }

    public function update(Request $request, Jurnal $jurnal)
    {
        $data = $request->validate([
            'nis_siswa'  => 'required|exists:tbl_siswa,nis_siswa',
            'kd_tempat'  => 'required|exists:tbl_tempat,kd_tempat',
            'tanggal'    => 'required|date',
            'jam_mulai'  => 'required|string|max:10',
            'jam_selesai'=> 'nullable|string|max:10',
            'kegiatan'   => 'required|string|max:100',
            'deskripsi'  => 'nullable|string',
        ]);

        $jurnal->update($data);

        return redirect()->route('admin.jurnal.index')->with('status', 'Data jurnal berhasil diperbarui.');
    }

    public function destroy(Jurnal $jurnal)
    {
        $jurnal->delete();

        return redirect()->route('admin.jurnal.index')->with('status', 'Data jurnal berhasil dihapus.');
    }

    public function exportCsv(Request $request)
    {
        $filters = [
            'jurusan' => $request->query('jurusan'),
            'kelas'   => $request->query('kelas'),
            'tahun'   => $request->query('tahun'),
        ];

        $query = Jurnal::with(['siswa.kelas.jurusan', 'tempat.industri']);

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

        $jurnals = $query->get();

        $filename = 'jurnal-pkl-'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($jurnals) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Tanggal',
                'Nama Siswa',
                'Industri / Tempat',
                'Jam Mulai',
                'Jam Selesai',
                'Kegiatan',
            ]);

            foreach ($jurnals as $item) {
                $siswa = optional($item->siswa);
                $tempat = optional($item->tempat);
                $industri = optional($tempat->industri);

                fputcsv($handle, [
                    optional($item->tanggal)->format('Y-m-d'),
                    $siswa->nama_lengkap,
                    $industri->nama_industri ?: $tempat->kd_tempat,
                    $item->jam_mulai,
                    $item->jam_selesai,
                    $item->kegiatan,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
