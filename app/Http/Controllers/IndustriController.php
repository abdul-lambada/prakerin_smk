<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use Illuminate\Http\Request;

class IndustriController extends Controller
{
    public function index()
    {
        $industri = Industri::with('tempat')->get();
        return response()->json($industri);
    }

    public function create()
    {
        return response()->json();
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
            'foto'            => 'nullable|string',
        ]);

        $industri = Industri::create($data);

        return response()->json($industri, 201);
    }

    public function show(Industri $industri)
    {
        $industri->load('tempat');
        return response()->json($industri);
    }

    public function edit(Industri $industri)
    {
        return response()->json($industri);
    }

    public function update(Request $request, Industri $industri)
    {
        $data = $request->validate([
            'nama_industri'   => 'sometimes|string|max:50',
            'bidang_kerja'    => 'sometimes|string|max:50',
            'deskripsi'       => 'sometimes|string',
            'alamat_industri' => 'sometimes|string',
            'wilayah'         => 'sometimes|string|max:50',
            'telepon'         => 'sometimes|string|max:20',
            'kuota'           => 'sometimes|integer',
            'foto'            => 'nullable|string',
        ]);

        $industri->update($data);

        return response()->json($industri);
    }

    public function destroy(Industri $industri)
    {
        $industri->delete();
        return response()->json(null, 204);
    }
}
