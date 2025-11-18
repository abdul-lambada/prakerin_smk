<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $nilai = Nilai::with('tempat')->get();
        return response()->json($nilai);
    }

    public function create()
    {
        return response()->json();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kd_tempat'  => 'required|exists:tbl_tempat,kd_tempat',
            'keterangan' => 'required|in:lulus,tidak-lulus',
            'nilai'      => 'required|numeric',
        ]);

        $nilai = Nilai::create($data);

        return response()->json($nilai->load('tempat'), 201);
    }

    public function show(Nilai $nilai)
    {
        $nilai->load('tempat');
        return response()->json($nilai);
    }

    public function edit(Nilai $nilai)
    {
        $nilai->load('tempat');
        return response()->json($nilai);
    }

    public function update(Request $request, Nilai $nilai)
    {
        $data = $request->validate([
            'kd_tempat'  => 'sometimes|exists:tbl_tempat,kd_tempat',
            'keterangan' => 'sometimes|in:lulus,tidak-lulus',
            'nilai'      => 'sometimes|numeric',
        ]);

        $nilai->update($data);

        return response()->json($nilai->load('tempat'));
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return response()->json(null, 204);
    }
}
