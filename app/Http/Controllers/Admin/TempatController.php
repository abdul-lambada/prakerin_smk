<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tempat;
use App\Models\Siswa;
use App\Models\Pembimbing;
use App\Models\Industri;
use Illuminate\Http\Request;

class TempatController extends Controller
{
    public function index()
    {
        $tempats = Tempat::with(['siswa', 'pembimbing', 'industri'])->get();
        return view('admin.tempat.index', compact('tempats'));
    }

    public function create()
    {
        $siswas      = Siswa::with('kelas')->get();
        $pembimbings = Pembimbing::with('user')->get();
        $industris   = Industri::all();

        return view('admin.tempat.create', compact('siswas', 'pembimbings', 'industris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kd_industri'   => 'required|exists:tbl_industri,kd_industri',
            'nis_siswa'     => 'required|exists:tbl_siswa,nis_siswa',
            'kd_pembimbing' => 'required|exists:tbl_pembimbing,kd_pembimbing',
            'tanggal'       => 'required|date',
            'wilayah'       => 'required|string|max:100',
            'tahun'         => 'required|integer',
            'status'        => 'required|string|max:50',
            'surat'         => 'nullable|string|max:255',
        ]);

        Tempat::create($data);

        return redirect()->route('admin.tempat.index')->with('status', 'Penempatan PKL berhasil ditambahkan.');
    }

    public function edit(Tempat $tempat)
    {
        $siswas      = Siswa::with('kelas')->get();
        $pembimbings = Pembimbing::with('user')->get();
        $industris   = Industri::all();

        return view('admin.tempat.edit', compact('tempat', 'siswas', 'pembimbings', 'industris'));
    }

    public function update(Request $request, Tempat $tempat)
    {
        $data = $request->validate([
            'kd_industri'   => 'required|exists:tbl_industri,kd_industri',
            'nis_siswa'     => 'required|exists:tbl_siswa,nis_siswa',
            'kd_pembimbing' => 'required|exists:tbl_pembimbing,kd_pembimbing',
            'tanggal'       => 'required|date',
            'wilayah'       => 'required|string|max:100',
            'tahun'         => 'required|integer',
            'status'        => 'required|string|max:50',
            'surat'         => 'nullable|string|max:255',
        ]);

        $tempat->update($data);

        return redirect()->route('admin.tempat.index')->with('status', 'Penempatan PKL berhasil diperbarui.');
    }

    public function destroy(Tempat $tempat)
    {
        $tempat->delete();

        return redirect()->route('admin.tempat.index')->with('status', 'Penempatan PKL berhasil dihapus.');
    }
}
