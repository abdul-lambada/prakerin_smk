<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['jurusan', 'siswa'])->get();
        return response()->json($kelas);
    }

    public function create()
    {
        return response()->json();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kd_jurusan' => 'required|exists:tbl_jurusan,kd_jurusan',
            'nama'       => 'required|string|max:20',
        ]);

        $kelas = Kelas::create($data);

        return response()->json($kelas->load('jurusan'), 201);
    }

    public function show(Kelas $kela)
    {
        $kela->load(['jurusan', 'siswa']);
        return response()->json($kela);
    }

    public function edit(Kelas $kela)
    {
        $kela->load('jurusan');
        return response()->json($kela);
    }

    public function update(Request $request, Kelas $kela)
    {
        $data = $request->validate([
            'kd_jurusan' => 'sometimes|exists:tbl_jurusan,kd_jurusan',
            'nama'       => 'sometimes|string|max:20',
        ]);

        $kela->update($data);

        return response()->json($kela->load('jurusan'));
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return response()->json(null, 204);
    }
}
