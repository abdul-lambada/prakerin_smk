<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industri;
use App\Models\User;
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
        $dudis = User::where('role', 'dudi')->orderBy('name')->get();

        return view('admin.industri.create', compact('dudis'));
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
            'user_id'         => 'nullable|exists:users,id',
        ]);

        Industri::create($data + ['foto' => $request->input('foto', '')]);

        return redirect()->route('admin.industri.index')->with('status', 'Data industri berhasil ditambahkan.');
    }

    public function edit(Industri $industri)
    {
        $dudis = User::where('role', 'dudi')->orderBy('name')->get();

        return view('admin.industri.edit', compact('industri', 'dudis'));
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
            'user_id'         => 'nullable|exists:users,id',
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
