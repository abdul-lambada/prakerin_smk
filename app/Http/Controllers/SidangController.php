<?php

namespace App\Http\Controllers;

use App\Models\Sidang;
use Illuminate\Http\Request;

class SidangController extends Controller
{
    public function index()
    {
        $sidang = Sidang::with(['siswa.user', 'tempat', 'industri'])->get();
        return response()->json($sidang);
    }

    public function create()
    {
        return response()->json();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis_siswa'  => 'required|exists:tbl_siswa,nis_siswa',
            'kd_tempat'  => 'required|exists:tbl_tempat,kd_tempat',
            'kd_industri'=> 'required|exists:tbl_industri,kd_industri',
            'judul'      => 'required|string',
            'file'       => 'nullable|string',
        ]);

        $sidang = Sidang::create($data);

        return response()->json($sidang->load(['siswa.user', 'tempat', 'industri']), 201);
    }

    public function show(Sidang $sidang)
    {
        $sidang->load(['siswa.user', 'tempat', 'industri']);
        return response()->json($sidang);
    }

    public function edit(Sidang $sidang)
    {
        $sidang->load(['siswa.user', 'tempat', 'industri']);
        return response()->json($sidang);
    }

    public function update(Request $request, Sidang $sidang)
    {
        $data = $request->validate([
            'nis_siswa'  => 'sometimes|exists:tbl_siswa,nis_siswa',
            'kd_tempat'  => 'sometimes|exists:tbl_tempat,kd_tempat',
            'kd_industri'=> 'sometimes|exists:tbl_industri,kd_industri',
            'judul'      => 'sometimes|string',
            'file'       => 'nullable|string',
        ]);

        $sidang->update($data);

        return response()->json($sidang->load(['siswa.user', 'tempat', 'industri']));
    }

    public function destroy(Sidang $sidang)
    {
        $sidang->delete();
        return response()->json(null, 204);
    }
}
