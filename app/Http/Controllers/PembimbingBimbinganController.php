<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Pembimbing;
use App\Models\Tempat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PembimbingBimbinganController extends Controller
{
    public function show(Request $request, Tempat $tempat)
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('user_id', $user->id)->firstOrFail();

        if ($tempat->kd_pembimbing !== $pembimbing->kd_pembimbing) {
            abort(403);
        }

        $tempat->load(['siswa', 'industri', 'pembimbing.user']);

        // Tandai semua pesan sebagai sudah dibaca oleh pembimbing
        Bimbingan::where('kd_tempat', $tempat->kd_tempat)
            ->update(['is_read_pembimbing' => true]);

        $query = Bimbingan::where('kd_tempat', $tempat->kd_tempat);

        if ($filter = $request->query('filter_judul')) {
            $query->where('judul', $filter);
        }

        $bimbingans = $query->orderBy('tanggal')->get();

        $selectedFilter = $request->query('filter_judul');

        return view('pembimbing.bimbingan.show', compact('pembimbing', 'tempat', 'bimbingans', 'selectedFilter'));
    }

    public function store(Request $request, Tempat $tempat)
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('user_id', $user->id)->firstOrFail();

        if ($tempat->kd_pembimbing !== $pembimbing->kd_pembimbing) {
            abort(403);
        }

        $data = $request->validate([
            'judul'   => 'nullable|string|max:50',
            'catatan' => 'required|string',
            'file'    => 'nullable|file|max:4096',
        ]);

        $data['kd_tempat']         = $tempat->kd_tempat;
        $data['nis_siswa']         = $tempat->nis_siswa;
        $data['nip']               = $pembimbing->nip;
        $data['tanggal']           = now()->toDateString();
        $data['is_read_pembimbing']= true;
        $data['is_read_siswa']     = false;

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('bimbingan', 'public');
        } else {
            $data['file'] = '';
        }

        Bimbingan::create($data);

        return redirect()->route('pembimbing.bimbingan.show', $tempat)->with('status', 'Pesan bimbingan berhasil dikirim.');
    }
}
