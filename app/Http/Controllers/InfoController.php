<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::with('user')->latest('tanggal')->get();
        return response()->json($infos);
    }

    public function create()
    {
        return response()->json();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'  => 'required|exists:users,id',
            'judul'    => 'required|string|max:100',
            'isi'      => 'required|string',
            'tanggal'  => 'required|date',
            'kategori' => 'nullable|string|max:50',
            'file'     => 'nullable|string',
        ]);

        $info = Info::create($data);

        return response()->json($info, 201);
    }

    public function show(Info $info)
    {
        $info->load('user');
        return response()->json($info);
    }

    public function edit(Info $info)
    {
        $info->load('user');
        return response()->json($info);
    }

    public function update(Request $request, Info $info)
    {
        $data = $request->validate([
            'user_id'  => 'sometimes|exists:users,id',
            'judul'    => 'sometimes|string|max:100',
            'isi'      => 'sometimes|string',
            'tanggal'  => 'sometimes|date',
            'kategori' => 'nullable|string|max:50',
            'file'     => 'nullable|string',
        ]);

        $info->update($data);

        return response()->json($info);
    }

    public function destroy(Info $info)
    {
        $info->delete();
        return response()->json(null, 204);
    }
}
