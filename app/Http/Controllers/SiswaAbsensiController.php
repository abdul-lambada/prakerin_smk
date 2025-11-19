<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiswaAbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $absensis = Absensi::with('tempat')
            ->where('nis_siswa', $siswa->nis_siswa)
            ->orderByDesc('tanggal')
            ->get();

        return view('siswa.absensi.index', compact('siswa', 'absensis'));
    }

    public function create()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $tempats = Tempat::where('nis_siswa', $siswa->nis_siswa)->orderByDesc('tanggal')->get();

        return view('siswa.absensi.create', compact('siswa', 'tempats'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $data = $request->validate([
            'kd_tempat'  => 'required|exists:tbl_tempat,kd_tempat',
            'tanggal'    => 'required|date',
            'jam_masuk'  => 'required|string|max:10',
            'jam_keluar' => 'nullable|string|max:10',
            'status'     => 'required|string|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:100',
            'foto'       => 'nullable|image|max:2048',
        ]);

        $data['nis_siswa'] = $siswa->nis_siswa;

        // Pastikan kd_tempat milik siswa ini
        $tempatValid = Tempat::where('kd_tempat', $data['kd_tempat'])
            ->where('nis_siswa', $siswa->nis_siswa)
            ->exists();

        if (! $tempatValid) {
            abort(403, 'Tempat PKL tidak valid untuk siswa ini.');
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('absensi', 'public');
        }

        Absensi::create($data);

        return redirect()->route('siswa.absensi.index')->with('status', 'Absensi berhasil disimpan.');
    }
}
