<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\Siswa;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaJurnalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $jurnals = Jurnal::with('tempat')
            ->where('nis_siswa', $siswa->nis_siswa)
            ->orderByDesc('tanggal')
            ->get();

        return view('siswa.jurnal.index', compact('siswa', 'jurnals'));
    }

    public function create()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $tempats = Tempat::where('nis_siswa', $siswa->nis_siswa)->orderByDesc('tanggal')->get();

        return view('siswa.jurnal.create', compact('siswa', 'tempats'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $data = $request->validate([
            'kd_tempat'   => 'required|exists:tbl_tempat,kd_tempat',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required|string|max:10',
            'jam_selesai' => 'nullable|string|max:10',
            'kegiatan'    => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
        ]);

        $data['nis_siswa'] = $siswa->nis_siswa;

        $tempatValid = Tempat::where('kd_tempat', $data['kd_tempat'])
            ->where('nis_siswa', $siswa->nis_siswa)
            ->exists();

        if (! $tempatValid) {
            abort(403, 'Tempat PKL tidak valid untuk siswa ini.');
        }

        Jurnal::create($data);

        return redirect()->route('siswa.jurnal.index')->with('status', 'Jurnal berhasil disimpan.');
    }
}
