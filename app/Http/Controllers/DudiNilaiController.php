<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DudiNilaiController extends Controller
{
    public function edit(Tempat $tempat)
    {
        $user = Auth::user();

        // Pastikan tempat ini milik industri yang dipegang DUDI ini
        $industri = $tempat->industri;
        if (! $industri || (string)$industri->user_id !== (string)$user->id) {
            abort(403, 'Anda tidak berhak menilai siswa ini.');
        }

        $nilai = Nilai::where('kd_tempat', $tempat->kd_tempat)->first();

        return view('dudi.nilai.edit', compact('tempat', 'nilai', 'industri'));
    }

    public function update(Request $request, Tempat $tempat)
    {
        $user = Auth::user();

        $industri = $tempat->industri;
        if (! $industri || (string)$industri->user_id !== (string)$user->id) {
            abort(403, 'Anda tidak berhak menilai siswa ini.');
        }

        $data = $request->validate([
            'nilai_du_di' => 'required|numeric|min:0|max:100',
            'keterangan'  => 'nullable|string|max:100',
        ]);

        $nilai = Nilai::firstOrNew(['kd_tempat' => $tempat->kd_tempat]);

        // Jika record baru, set bobot default (admin masih bisa ubah nanti)
        if (! $nilai->exists) {
            $nilai->bobot_du_di   = $nilai->bobot_du_di   ?? 60;
            $nilai->bobot_sidang  = $nilai->bobot_sidang  ?? 40;
        }

        $nilai->nilai_du_di = $data['nilai_du_di'];
        // Biarkan nilai_sidang, nilai_akhir, predikat diisi/admin oleh admin
        $nilai->keterangan  = $data['keterangan'] ?? $nilai->keterangan;

        $nilai->save();

        return redirect()->route('dudi.siswa.index')->with('status', 'Nilai DU/DI berhasil disimpan.');
    }
}
