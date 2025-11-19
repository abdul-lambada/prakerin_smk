<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sidang;
use App\Models\Tempat;
use App\Models\Siswa;
use App\Models\Industri;
use Illuminate\Http\Request;

class SidangController extends Controller
{
    public function index()
    {
        $sidangs = Sidang::with(['siswa', 'tempat', 'industri'])->get();
        return view('admin.sidang.index', compact('sidangs'));
    }

    public function create()
    {
        $siswas  = Siswa::all();
        $tempats = Tempat::all();
        $industris = Industri::all();

        return view('admin.sidang.create', compact('siswas', 'tempats', 'industris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis_siswa' => 'required|exists:tbl_siswa,nis_siswa',
            'kd_tempat' => 'required|exists:tbl_tempat,kd_tempat',
            'kd_industri' => 'required|exists:tbl_industri,kd_industri',
            'tanggal'   => 'required|date',
            'nilai'     => 'required|numeric|min:0|max:100',
            'keterangan'=> 'nullable|string|max:100',
        ]);

        Sidang::create($data);

        return redirect()->route('admin.sidang.index')->with('status', 'Data sidang berhasil ditambahkan.');
    }

    public function edit(Sidang $sidang)
    {
        $siswas  = Siswa::all();
        $tempats = Tempat::all();
        $industris = Industri::all();

        return view('admin.sidang.edit', compact('sidang', 'siswas', 'tempats', 'industris'));
    }

    public function update(Request $request, Sidang $sidang)
    {
        $data = $request->validate([
            'nis_siswa' => 'required|exists:tbl_siswa,nis_siswa',
            'kd_tempat' => 'required|exists:tbl_tempat,kd_tempat',
            'kd_industri' => 'required|exists:tbl_industri,kd_industri',
            'tanggal'   => 'required|date',
            'nilai'     => 'required|numeric|min:0|max:100',
            'keterangan'=> 'nullable|string|max:100',
        ]);

        $sidang->update($data);

        return redirect()->route('admin.sidang.index')->with('status', 'Data sidang berhasil diperbarui.');
    }

    public function destroy(Sidang $sidang)
    {
        $sidang->delete();

        return redirect()->route('admin.sidang.index')->with('status', 'Data sidang berhasil dihapus.');
    }
}
