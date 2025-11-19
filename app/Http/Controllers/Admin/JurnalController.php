<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\Siswa;
use App\Models\Tempat;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::with(['siswa', 'tempat'])->get();
        return view('admin.jurnal.index', compact('jurnals'));
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
}
