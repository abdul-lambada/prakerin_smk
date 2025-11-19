<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industri;
use Illuminate\Http\Request;

class IndustriController extends Controller
{
    public function index()
    {
        $industris = Industri::all();
        return view('admin.industri.index', compact('industris'));
    }

    public function create()
    {
        return view('admin.industri.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_industri'   => 'required|string|max:50',
            'bidang_kerja'    => 'required|string|max:50',
            'deskripsi'       => 'required|string',
            'alamat_industri' => 'required|string',
            'wilayah'         => 'required|string|max:50',
            'telepon'         => 'required|string|max:20',
            'kuota'           => 'required|integer',
        ]);

        Industri::create($data + ['foto' => $request->input('foto', '')]);

        return redirect()->route('admin.industri.index')->with('status', 'Data industri berhasil ditambahkan.');
    }

    public function edit(Industri $industri)
    {
        return view('admin.industri.edit', compact('industri'));
    }

    public function update(Request $request, Industri $industri)
    {
        $data = $request->validate([
            'nama_industri'   => 'required|string|max:50',
            'bidang_kerja'    => 'required|string|max:50',
            'deskripsi'       => 'required|string',
            'alamat_industri' => 'required|string',
            'wilayah'         => 'required|string|max:50',
            'telepon'         => 'required|string|max:20',
            'kuota'           => 'required|integer',
        ]);

        $industri->update($data);

        return redirect()->route('admin.industri.index')->with('status', 'Data industri berhasil diperbarui.');
    }

    public function destroy(Industri $industri)
    {
        $industri->delete();

        return redirect()->route('admin.industri.index')->with('status', 'Data industri berhasil dihapus.');
    }
}
