<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('jurusan')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('admin.kelas.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kd_jurusan' => 'required|exists:tbl_jurusan,kd_jurusan',
            'nama'       => 'required|string|max:100',
        ]);

        Kelas::create($data);

        return redirect()->route('admin.kelas.index')->with('status', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        $jurusans = Jurusan::all();
        $kelas    = $kela;
        return view('admin.kelas.edit', compact('kelas', 'jurusans'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $data = $request->validate([
            'kd_jurusan' => 'required|exists:tbl_jurusan,kd_jurusan',
            'nama'       => 'required|string|max:100',
        ]);

        $kela->update($data);

        return redirect()->route('admin.kelas.index')->with('status', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();

        return redirect()->route('admin.kelas.index')->with('status', 'Data kelas berhasil dihapus.');
    }
}
