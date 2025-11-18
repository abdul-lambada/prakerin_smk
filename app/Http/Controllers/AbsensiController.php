<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::with(['siswa.user', 'tempat'])->get();
        return response()->json($absensi);
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
            'tanggal'    => 'required|date',
            'jam_masuk'  => 'nullable|date_format:H:i:s',
            'jam_keluar' => 'nullable|date_format:H:i:s',
            'status'     => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string',
        ]);

        $absensi = Absensi::create($data);

        return response()->json($absensi->load(['siswa.user', 'tempat']), 201);
    }

    public function show(Absensi $absensi)
    {
        $absensi->load(['siswa.user', 'tempat']);
        return response()->json($absensi);
    }

    public function edit(Absensi $absensi)
    {
        $absensi->load(['siswa.user', 'tempat']);
        return response()->json($absensi);
    }

    public function update(Request $request, Absensi $absensi)
    {
        $data = $request->validate([
            'nis_siswa'  => 'sometimes|exists:tbl_siswa,nis_siswa',
            'kd_tempat'  => 'sometimes|exists:tbl_tempat,kd_tempat',
            'tanggal'    => 'sometimes|date',
            'jam_masuk'  => 'nullable|date_format:H:i:s',
            'jam_keluar' => 'nullable|date_format:H:i:s',
            'status'     => 'sometimes|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string',
        ]);

        $absensi->update($data);

        return response()->json($absensi->load(['siswa.user', 'tempat']));
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return response()->json(null, 204);
    }
}
