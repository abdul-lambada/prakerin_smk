<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Tempat;
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
            'kd_tempat' => 'required|exists:tbl_tempat,kd_tempat',
            'nilai'     => 'required|numeric|min:0|max:100',
            'keterangan'=> 'nullable|string|max:50',
        ]);

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
            'kd_tempat' => 'required|exists:tbl_tempat,kd_tempat',
            'nilai'     => 'required|numeric|min:0|max:100',
            'keterangan'=> 'nullable|string|max:50',
        ]);

        $nilai->update($data);

        return redirect()->route('admin.nilai.index')->with('status', 'Nilai PKL berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()->route('admin.nilai.index')->with('status', 'Nilai PKL berhasil dihapus.');
    }
}
