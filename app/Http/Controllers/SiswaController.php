<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['user', 'kelas.jurusan', 'pembimbing.user'])->get();
        return response()->json($siswa);
    }

    public function create()
    {
        return response()->json();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kd_kelas'     => 'required|exists:tbl_kelas,kd_kelas',
            'user_id'      => 'required|exists:users,id',
            'nama_lengkap' => 'required|string|max:500',
            'telp'         => 'required|string|max:14',
            'foto'         => 'nullable|string',
            'kd_pembimbing'=> 'required|exists:tbl_pembimbing,kd_pembimbing',
        ]);

        $siswa = Siswa::create($data);

        return response()->json($siswa->load(['user', 'kelas.jurusan', 'pembimbing.user']), 201);
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['user', 'kelas.jurusan', 'pembimbing.user', 'tempat']);
        return response()->json($siswa);
    }

    public function edit(Siswa $siswa)
    {
        $siswa->load(['user', 'kelas.jurusan', 'pembimbing.user']);
        return response()->json($siswa);
    }

    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'kd_kelas'     => 'sometimes|exists:tbl_kelas,kd_kelas',
            'user_id'      => 'sometimes|exists:users,id',
            'nama_lengkap' => 'sometimes|string|max:500',
            'telp'         => 'sometimes|string|max:14',
            'foto'         => 'nullable|string',
            'kd_pembimbing'=> 'sometimes|exists:tbl_pembimbing,kd_pembimbing',
        ]);

        $siswa->update($data);

        return response()->json($siswa->load(['user', 'kelas.jurusan', 'pembimbing.user']));
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return response()->json(null, 204);
    }
}
