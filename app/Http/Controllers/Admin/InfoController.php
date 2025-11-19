<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Storage;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::with('user')->orderByDesc('created_at')->get();
        return view('admin.info.index', compact('infos'));
    }

    public function create()
    {
        return view('admin.info.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'   => 'required|string|max:150',
            'isi'     => 'required|string',
            'tanggal' => 'required|date',
            'kategori'=> 'nullable|string|max:100',
            'file'    => 'nullable|file|max:2048',
        ]);

        $data['user_id'] = Auth::id();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('info', 'public');
        }

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('info', 'public');
        }

        Info::create($data);

        return redirect()->route('admin.info.index')->with('status', 'Info berhasil ditambahkan.');
    }

    public function edit(Info $info)
    {
        return view('admin.info.edit', compact('info'));
    }

    public function update(Request $request, Info $info)
    {
        $data = $request->validate([
            'judul'   => 'required|string|max:150',
            'isi'     => 'required|string',
            'tanggal' => 'required|date',
            'kategori'=> 'nullable|string|max:100',
            'file'    => 'nullable|file|max:2048',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('file')) {
            if ($info->file && Storage::disk('public')->exists($info->file)) {
                Storage::disk('public')->delete($info->file);
            }

            $data['file'] = $request->file('file')->store('info', 'public');
        }

        if ($request->hasFile('lampiran')) {
            if ($info->lampiran && Storage::disk('public')->exists($info->lampiran)) {
                Storage::disk('public')->delete($info->lampiran);
            }

            $data['lampiran'] = $request->file('lampiran')->store('info', 'public');
        }

        $info->update($data);

        return redirect()->route('admin.info.index')->with('status', 'Info berhasil diperbarui.');
    }

    public function destroy(Info $info)
    {
        $info->delete();

        return redirect()->route('admin.info.index')->with('status', 'Info berhasil dihapus.');
    }
}
