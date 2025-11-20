<?php

namespace App\Http\Controllers;

use App\Models\ChatDudiPembimbing;
use App\Models\Industri;
use App\Models\Tempat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DudiChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Industri yang terhubung ke akun DUDI ini
        $industri = Industri::where('user_id', $user->id)->first();

        $tempats = collect();
        $pembimbingUsers = collect();

        if ($industri) {
            $tempats = Tempat::with(['siswa', 'pembimbing.user'])
                ->where('kd_industri', $industri->kd_industri)
                ->orderByDesc('tanggal')
                ->get();

            // Kumpulan user pembimbing yang terkait dengan industri ini
            $pembimbingUsers = $tempats
                ->pluck('pembimbing.user')
                ->filter()
                ->unique('id')
                ->values();
        }

        // Riwayat pesan antara DUDI ini dan semua pembimbing
        $chats = ChatDudiPembimbing::with(['fromUser', 'toUser', 'tempat.siswa'])
            ->where(function ($q) use ($user) {
                $q->where('from_user_id', $user->id)
                  ->orWhere('to_user_id', $user->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Tandai pesan ke DUDI sebagai sudah dibaca
        ChatDudiPembimbing::where('to_user_id', $user->id)
            ->where('is_read_dudi', false)
            ->update(['is_read_dudi' => true]);

        return view('dudi.chat.index', compact('industri', 'tempats', 'pembimbingUsers', 'chats'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'kategori'      => 'required|in:kritik_saran,monitoring_siswa',
            'pembimbing_id' => 'nullable|exists:users,id',
            'kd_tempat'     => 'nullable|exists:tbl_tempat,kd_tempat',
            'pesan'         => 'required|string',
        ]);

        // Tentukan penerima (user pembimbing)
        $toUserId = null;

        if ($data['kategori'] === 'monitoring_siswa') {
            // Untuk monitoring siswa, kd_tempat wajib diisi
            if (empty($data['kd_tempat'])) {
                return back()->withErrors(['kd_tempat' => 'Pilih siswa / tempat untuk Monitoring Siswa.'])->withInput();
            }

            // Ambil pembimbing dari kd_tempat
            $tempat = Tempat::with('pembimbing.user')->findOrFail($data['kd_tempat']);
            $toUserId = optional(optional($tempat->pembimbing)->user)->id;
        } else { // kritik_saran
            if (empty($data['pembimbing_id'])) {
                return back()->withErrors(['pembimbing_id' => 'Pilih pembimbing tujuan untuk Kritik & Saran.'])->withInput();
            }
            $toUserId = $data['pembimbing_id'];
        }

        if (! $toUserId) {
            return back()->withErrors(['pembimbing_id' => 'Tidak dapat menentukan pembimbing tujuan.'])->withInput();
        }

        ChatDudiPembimbing::create([
            'from_user_id'       => $user->id,
            'to_user_id'         => $toUserId,
            'kategori'           => $data['kategori'],
            'judul'              => null,
            'pesan'              => $data['pesan'],
            'kd_tempat'          => $data['kategori'] === 'monitoring_siswa' ? $data['kd_tempat'] : null,
            'is_read_dudi'       => true,
            'is_read_pembimbing' => false,
        ]);

        return redirect()->route('dudi.chat.index')->with('status', 'Pesan berhasil dikirim ke pembimbing.');
    }
}
