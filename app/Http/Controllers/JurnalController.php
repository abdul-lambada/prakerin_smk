<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    public function index()
    {
        $jurnal = Jurnal::with(['siswa.user', 'tempat'])->get();
        return response()->json($jurnal);
    }

    public function create()
    {
        return response()->json();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis_siswa'   => 'required|exists:tbl_siswa,nis_siswa',
            'kd_tempat'   => 'required|exists:tbl_tempat,kd_tempat',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'nullable|date_format:H:i:s',
            'jam_selesai' => 'nullable|date_format:H:i:s',
            'kegiatan'    => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
        ]);

        $jurnal = Jurnal::create($data);

        return response()->json($jurnal->load(['siswa.user', 'tempat']), 201);
    }

    public function show(Jurnal $jurnal)
    {
        $jurnal->load(['siswa.user', 'tempat']);
        return response()->json($jurnal);
    }

    public function edit(Jurnal $jurnal)
    {
        $jurnal->load(['siswa.user', 'tempat']);
        return response()->json($jurnal);
    }

    public function update(Request $request, Jurnal $jurnal)
    {
        $data = $request->validate([
            'nis_siswa'   => 'sometimes|exists:tbl_siswa,nis_siswa',
            'kd_tempat'   => 'sometimes|exists:tbl_tempat,kd_tempat',
            'tanggal'     => 'sometimes|date',
            'jam_mulai'   => 'nullable|date_format:H:i:s',
            'jam_selesai' => 'nullable|date_format:H:i:s',
            'kegiatan'    => 'sometimes|string|max:100',
            'deskripsi'   => 'nullable|string',
        ]);

        $jurnal->update($data);

        return response()->json($jurnal->load(['siswa.user', 'tempat']));
    }

    public function destroy(Jurnal $jurnal)
    {
        $jurnal->delete();
        return response()->json(null, 204);
    }
}
