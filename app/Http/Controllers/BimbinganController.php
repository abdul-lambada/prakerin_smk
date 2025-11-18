<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index()
    {
        $bimbingan = Bimbingan::with(['siswa.user', 'tempat'])->get();
        return response()->json($bimbingan);
    }

    public function create()
    {
        return response()->json();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kd_tempat' => 'required|exists:tbl_tempat,kd_tempat',
            'nip'       => 'required|string|max:21',
            'nis_siswa' => 'required|exists:tbl_siswa,nis_siswa',
            'tanggal'   => 'required|date',
            'judul'     => 'required|string|max:50',
            'catatan'   => 'required|string',
            'file'      => 'nullable|string',
        ]);

        $bimbingan = Bimbingan::create($data);

        return response()->json($bimbingan->load(['siswa.user', 'tempat']), 201);
    }

    public function show(Bimbingan $bimbingan)
    {
        $bimbingan->load(['siswa.user', 'tempat']);
        return response()->json($bimbingan);
    }

    public function edit(Bimbingan $bimbingan)
    {
        $bimbingan->load(['siswa.user', 'tempat']);
        return response()->json($bimbingan);
    }

    public function update(Request $request, Bimbingan $bimbingan)
    {
        $data = $request->validate([
            'kd_tempat' => 'sometimes|exists:tbl_tempat,kd_tempat',
            'nip'       => 'sometimes|string|max:21',
            'nis_siswa' => 'sometimes|exists:tbl_siswa,nis_siswa',
            'tanggal'   => 'sometimes|date',
            'judul'     => 'sometimes|string|max:50',
            'catatan'   => 'sometimes|string',
            'file'      => 'nullable|string',
        ]);

        $bimbingan->update($data);

        return response()->json($bimbingan->load(['siswa.user', 'tempat']));
    }

    public function destroy(Bimbingan $bimbingan)
    {
        $bimbingan->delete();
        return response()->json(null, 204);
    }
}
