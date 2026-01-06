<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use App\Models\Tempat;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PembimbingNilaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pembimbing = Pembimbing::where('user_id', $user->id)->firstOrFail();

        $tempats = Tempat::with(['siswa', 'nilai'])
            ->where('kd_pembimbing', $pembimbing->kd_pembimbing)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pembimbing.nilai.index', compact('pembimbing', 'tempats'));
    }

    public function edit(Tempat $tempat)
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('user_id', $user->id)->firstOrFail();

        // Pastikan tempat ini milik pembimbing login
        if ((string)$tempat->kd_pembimbing !== (string)$pembimbing->kd_pembimbing) {
            abort(403);
        }

        $tempat->load(['siswa', 'industri', 'nilai']);

        return view('pembimbing.nilai.edit', compact('pembimbing', 'tempat'));
    }

    public function save(Request $request, Tempat $tempat)
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('user_id', $user->id)->firstOrFail();

        if ((string)$tempat->kd_pembimbing !== (string)$pembimbing->kd_pembimbing) {
            abort(403);
        }

        $data = $request->validate([
            'nilai'      => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:50',
        ]);

        $data['kd_tempat'] = $tempat->kd_tempat;

        if ($tempat->nilai) {
            $tempat->nilai->update($data);
        } else {
            Nilai::create($data);
        }

        return redirect()->route('pembimbing.nilai.index')->with('status', 'Nilai PKL berhasil disimpan.');
    }
}
