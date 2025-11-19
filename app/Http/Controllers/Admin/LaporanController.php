<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Siswa;
use App\Models\Tempat;
use App\Models\Industri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::with(['siswa', 'tempat', 'industri'])->get();
        return view('admin.laporan.index', compact('laporans'));
    }

    public function create()
    {
        $siswas    = Siswa::all();
        $tempats   = Tempat::all();
        $industris = Industri::all();
        return view('admin.laporan.create', compact('siswas', 'tempats', 'industris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis_siswa'  => 'required|exists:tbl_siswa,nis_siswa',
            'kd_tempat'  => 'required|exists:tbl_tempat,kd_tempat',
            'kd_industri'=> 'required|exists:tbl_industri,kd_industri',
            'judul'      => 'required|string|max:150',
            'file'       => 'required|file|max:4096',
        ]);

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('laporan', 'public');
        }

        Laporan::create($data);

        return redirect()->route('admin.laporan.index')->with('status', 'Laporan PKL berhasil ditambahkan.');
    }

    public function edit(Laporan $laporan)
    {
        $siswas    = Siswa::all();
        $tempats   = Tempat::all();
        $industris = Industri::all();
        return view('admin.laporan.edit', compact('laporan', 'siswas', 'tempats', 'industris'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $data = $request->validate([
            'nis_siswa'  => 'required|exists:tbl_siswa,nis_siswa',
            'kd_tempat'  => 'required|exists:tbl_tempat,kd_tempat',
            'kd_industri'=> 'required|exists:tbl_industri,kd_industri',
            'judul'      => 'required|string|max:150',
            'file'       => 'nullable|file|max:4096',
        ]);

        if ($request->hasFile('file')) {
            if ($laporan->file && Storage::disk('public')->exists($laporan->file)) {
                Storage::disk('public')->delete($laporan->file);
            }

            $data['file'] = $request->file('file')->store('laporan', 'public');
        }

        $laporan->update($data);

        return redirect()->route('admin.laporan.index')->with('status', 'Laporan PKL berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        if ($laporan->file && Storage::disk('public')->exists($laporan->file)) {
            Storage::disk('public')->delete($laporan->file);
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('status', 'Laporan PKL berhasil dihapus.');
    }
}
