<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::with(['siswa', 'tempat'])->get();
        return view('admin.absensi.index', compact('absensis'));
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
}
