<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Siswa;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiswaLaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $laporans = Laporan::with('tempat.industri')
            ->where('nis_siswa', $siswa->nis_siswa)
            ->orderByDesc('kd_laporan')
            ->get();

        return view('siswa.laporan.index', compact('siswa', 'laporans'));
    }

    public function create()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $tempats = Tempat::where('nis_siswa', $siswa->nis_siswa)->orderByDesc('tanggal')->get();

        return view('siswa.laporan.create', compact('siswa', 'tempats'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $data = $request->validate([
            'kd_tempat' => 'required|exists:tbl_tempat,kd_tempat',
            'judul'     => 'required|string|max:150',
            'file'      => 'required|file|mimes:pdf,doc,docx|max:4096',
        ]);

        $data['nis_siswa'] = $siswa->nis_siswa;

        $tempat = Tempat::where('kd_tempat', $data['kd_tempat'])
            ->where('nis_siswa', $siswa->nis_siswa)
            ->first();

        if (! $tempat) {
            abort(403, 'Tempat PKL tidak valid untuk siswa ini.');
        }

        $data['kd_industri'] = $tempat->kd_industri;

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('laporan', 'public');
        }

        Laporan::create($data);

        return redirect()->route('siswa.laporan.index')->with('status', 'Laporan PKL berhasil diupload.');
    }
}
