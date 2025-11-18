<?php

namespace App\Http\Controllers;

use App\Models\Tempat;
use Illuminate\Http\Request;

class TempatController extends Controller
{
    public function index()
    {
        $tempat = Tempat::with([
            'siswa.user',
            'pembimbing.user',
            'industri',
            'bimbingan',
            'laporan',
            'nilai',
            'sidang',
            'absensi',
            'jurnal',
            'tolak',
        ])->get();

        return response()->json($tempat);
    }

    public function create()
    {
        return response()->json();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis_siswa'    => 'required|exists:tbl_siswa,nis_siswa',
            'kd_pembimbing'=> 'required|exists:tbl_pembimbing,kd_pembimbing',
            'kd_industri'  => 'required|exists:tbl_industri,kd_industri',
            'tanggal'      => 'required|date',
            'wilayah'      => 'required|string|max:50',
            'tahun'        => 'required|integer',
            'status'       => 'required|in:-,proses,ditolak,diterima',
            'surat'        => 'nullable|string',
        ]);

        $tempat = Tempat::create($data);

        return response()->json($tempat->load(['siswa.user', 'pembimbing.user', 'industri']), 201);
    }

    public function show(Tempat $tempat)
    {
        $tempat->load([
            'siswa.user',
            'pembimbing.user',
            'industri',
            'bimbingan',
            'laporan',
            'nilai',
            'sidang',
            'absensi',
            'jurnal',
            'tolak',
        ]);

        return response()->json($tempat);
    }

    public function edit(Tempat $tempat)
    {
        $tempat->load(['siswa.user', 'pembimbing.user', 'industri']);
        return response()->json($tempat);
    }

    public function update(Request $request, Tempat $tempat)
    {
        $data = $request->validate([
            'nis_siswa'    => 'sometimes|exists:tbl_siswa,nis_siswa',
            'kd_pembimbing'=> 'sometimes|exists:tbl_pembimbing,kd_pembimbing',
            'kd_industri'  => 'sometimes|exists:tbl_industri,kd_industri',
            'tanggal'      => 'sometimes|date',
            'wilayah'      => 'sometimes|string|max:50',
            'tahun'        => 'sometimes|integer',
            'status'       => 'sometimes|in:-,proses,ditolak,diterima',
            'surat'        => 'nullable|string',
        ]);

        $tempat->update($data);

        return response()->json($tempat->load(['siswa.user', 'pembimbing.user', 'industri']));
    }

    public function destroy(Tempat $tempat)
    {
        $tempat->delete();
        return response()->json(null, 204);
    }
}
