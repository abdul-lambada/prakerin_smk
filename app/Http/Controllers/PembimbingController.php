<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use Illuminate\Http\Request;

class PembimbingController extends Controller
{
    public function index()
    {
        $pembimbing = Pembimbing::with(['user', 'siswa', 'tempat'])->get();
        return response()->json($pembimbing);
    }

    public function create()
    {
        return response()->json();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'kd_jurusan'   => 'required|string|max:5',
            'nip'          => 'required|string|max:21',
            'nama_lengkap' => 'required|string|max:50',
            'wilayah'      => 'required|string|max:50',
        ]);

        $pembimbing = Pembimbing::create($data);

        return response()->json($pembimbing->load(['user']), 201);
    }

    public function show(Pembimbing $pembimbing)
    {
        $pembimbing->load(['user', 'siswa', 'tempat']);
        return response()->json($pembimbing);
    }

    public function edit(Pembimbing $pembimbing)
    {
        $pembimbing->load(['user']);
        return response()->json($pembimbing);
    }

    public function update(Request $request, Pembimbing $pembimbing)
    {
        $data = $request->validate([
            'user_id'      => 'sometimes|exists:users,id',
            'kd_jurusan'   => 'sometimes|string|max:5',
            'nip'          => 'sometimes|string|max:21',
            'nama_lengkap' => 'sometimes|string|max:50',
            'wilayah'      => 'sometimes|string|max:50',
        ]);

        $pembimbing->update($data);

        return response()->json($pembimbing->load(['user']));
    }

    public function destroy(Pembimbing $pembimbing)
    {
        $pembimbing->delete();
        return response()->json(null, 204);
    }
}
