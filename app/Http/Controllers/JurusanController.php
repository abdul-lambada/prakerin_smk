<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::with('kelas')->get();
        return response()->json($jurusan);
    }

    public function create()
    {
        return response()->json();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:50',
        ]);

        $jurusan = Jurusan::create($data);

        return response()->json($jurusan, 201);
    }

    public function show(Jurusan $jurusan)
    {
        $jurusan->load('kelas');
        return response()->json($jurusan);
    }

    public function edit(Jurusan $jurusan)
    {
        return response()->json($jurusan);
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $data = $request->validate([
            'nama' => 'sometimes|string|max:50',
        ]);

        $jurusan->update($data);

        return response()->json($jurusan);
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return response()->json(null, 204);
    }
}
