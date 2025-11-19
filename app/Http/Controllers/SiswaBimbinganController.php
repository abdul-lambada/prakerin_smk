<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Siswa;
use App\Models\Tempat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SiswaBimbinganController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $tempats = Tempat::with('industri', 'pembimbing.user')
            ->where('nis_siswa', $siswa->nis_siswa)
            ->withCount(['bimbingan as unread_from_pembimbing_count' => function ($q) use ($siswa) {
                $q->where('nis_siswa', $siswa->nis_siswa)
                  ->where('is_read_siswa', false)
                  ->whereNotNull('nip');
            }])
            ->withCount(['bimbingan as revisi_laporan_count' => function ($q) use ($siswa) {
                $q->where('nis_siswa', $siswa->nis_siswa)
                  ->where('judul', 'Revisi Laporan');
            }])
            ->orderByDesc('tanggal')
            ->get();

        return view('siswa.bimbingan.index', compact('siswa', 'tempats'));
    }

    public function show(Request $request, Tempat $tempat)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        if ($tempat->nis_siswa !== $siswa->nis_siswa) {
            abort(403);
        }

        $tempat->load(['industri', 'pembimbing.user']);

        // Tandai semua pesan sebagai sudah dibaca oleh siswa
        Bimbingan::where('kd_tempat', $tempat->kd_tempat)
            ->where('nis_siswa', $siswa->nis_siswa)
            ->update(['is_read_siswa' => true]);

        $query = Bimbingan::where('kd_tempat', $tempat->kd_tempat)
            ->where('nis_siswa', $siswa->nis_siswa);

        if ($filter = $request->query('filter_judul')) {
            $query->where('judul', $filter);
        }

        $bimbingans = $query->orderBy('tanggal')->get();

        $selectedFilter = $request->query('filter_judul');

        return view('siswa.bimbingan.show', compact('siswa', 'tempat', 'bimbingans', 'selectedFilter'));
    }

    public function store(Request $request, Tempat $tempat)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        if ($tempat->nis_siswa !== $siswa->nis_siswa) {
            abort(403);
        }

        $data = $request->validate([
            'judul'   => 'nullable|string|max:50',
            'catatan' => 'required|string',
            'file'    => 'nullable|file|max:4096',
        ]);

        $data['kd_tempat']        = $tempat->kd_tempat;
        $data['nis_siswa']        = $siswa->nis_siswa;
        $data['tanggal']          = now()->toDateString();
        $data['is_read_siswa']    = true;
        $data['is_read_pembimbing']= false;

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('bimbingan', 'public');
        }

        Bimbingan::create($data);

        return redirect()->route('siswa.bimbingan.show', $tempat)->with('status', 'Pesan bimbingan berhasil dikirim.');
    }
}
