<?php

namespace App\Http\Controllers;

use App\Models\ChatDudiPembimbing;
use App\Models\Industri;
use App\Models\Pembimbing;
use App\Models\Tempat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembimbingChatDudiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pembimbing = Pembimbing::where('user_id', $user->id)->firstOrFail();

        // Semua tempat yang dibimbing pembimbing ini
        $tempatQuery = Tempat::where('kd_pembimbing', $pembimbing->kd_pembimbing);

        $kdTempatList = $tempatQuery->pluck('kd_tempat');

        // Industri yang berkaitan dengan tempat-tempat ini
        $industriIds = Tempat::whereIn('kd_tempat', $kdTempatList)
            ->pluck('kd_industri')
            ->unique()
            ->filter();

        // User DUDI yang terhubung ke industri-industri tersebut
        $dudiUserIds = Industri::whereIn('kd_industri', $industriIds)
            ->pluck('user_id')
            ->unique()
            ->filter();

        $dudiUsers = User::where('role', 'dudi')
            ->whereIn('id', $dudiUserIds)
            ->get();

        // Hitung pesan belum dibaca dari tiap DUDI
        $unreadCounts = ChatDudiPembimbing::selectRaw('from_user_id, COUNT(*) as total')
            ->where('to_user_id', $user->id)
            ->where('is_read_pembimbing', false)
            ->groupBy('from_user_id')
            ->pluck('total', 'from_user_id');

        return view('pembimbing.chat_dudi.index', compact('dudiUsers', 'unreadCounts'));
    }

    public function show(User $dudi)
    {
        $user = Auth::user();

        // Ambil semua chat antara pembimbing ini dan user DUDI ini
        $chats = ChatDudiPembimbing::with(['fromUser', 'toUser', 'tempat.siswa'])
            ->where(function ($q) use ($user, $dudi) {
                $q->where('from_user_id', $user->id)->where('to_user_id', $dudi->id);
            })->orWhere(function ($q) use ($user, $dudi) {
                $q->where('from_user_id', $dudi->id)->where('to_user_id', $user->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Tandai pesan dari DUDI sebagai sudah dibaca
        ChatDudiPembimbing::where('from_user_id', $dudi->id)
            ->where('to_user_id', $user->id)
            ->where('is_read_pembimbing', false)
            ->update(['is_read_pembimbing' => true]);

        return view('pembimbing.chat_dudi.show', compact('dudi', 'chats'));
    }

    public function store(Request $request, User $dudi)
    {
        $user = Auth::user();

        $data = $request->validate([
            'pesan' => 'required|string',
        ]);

        // Ambil pesan terakhir dalam percakapan ini untuk mewarisi kategori dan kd_tempat
        $lastChat = ChatDudiPembimbing::where(function ($q) use ($user, $dudi) {
                $q->where('from_user_id', $user->id)->where('to_user_id', $dudi->id);
            })->orWhere(function ($q) use ($user, $dudi) {
                $q->where('from_user_id', $dudi->id)->where('to_user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->first();

        $kategori = $lastChat->kategori ?? 'kritik_saran';
        $kdTempat = $lastChat->kd_tempat ?? null;

        ChatDudiPembimbing::create([
            'from_user_id'       => $user->id,
            'to_user_id'         => $dudi->id,
            'kategori'           => $kategori,
            'judul'              => null,
            'pesan'              => $data['pesan'],
            'kd_tempat'          => $kdTempat,
            'is_read_dudi'       => false,
            'is_read_pembimbing' => true,
        ]);

        return redirect()->route('pembimbing.chat-dudi.show', $dudi)->with('status', 'Pesan berhasil dikirim ke DUDI.');
    }
}
