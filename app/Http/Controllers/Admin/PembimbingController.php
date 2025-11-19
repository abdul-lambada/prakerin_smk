<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;

class PembimbingController extends Controller
{
    public function index()
    {
        $pembimbings = Pembimbing::with(['user'])->get();
        return view('admin.pembimbing.index', compact('pembimbings'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        $users    = User::where('role', 'pembimbing')->get();

        return view('admin.pembimbing.create', compact('jurusans', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'kd_jurusan'   => 'required|exists:tbl_jurusan,kd_jurusan',
            'nip'          => 'required|string|max:30|unique:tbl_pembimbing,nip',
            'nama_lengkap' => 'required|string|max:100',
            'wilayah'      => 'required|string|max:100',
        ]);

        Pembimbing::create($data);

        return redirect()->route('admin.pembimbing.index')->with('status', 'Data pembimbing berhasil ditambahkan.');
    }

    public function edit(Pembimbing $pembimbing)
    {
        $jurusans = Jurusan::all();
        $users    = User::where('role', 'pembimbing')->get();

        return view('admin.pembimbing.edit', compact('pembimbing', 'jurusans', 'users'));
    }

    public function update(Request $request, Pembimbing $pembimbing)
    {
        $data = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'kd_jurusan'   => 'required|exists:tbl_jurusan,kd_jurusan',
            'nip'          => 'required|string|max:30|unique:tbl_pembimbing,nip,' . $pembimbing->kd_pembimbing . ',kd_pembimbing',
            'nama_lengkap' => 'required|string|max:100',
            'wilayah'      => 'required|string|max:100',
        ]);

        $pembimbing->update($data);

        return redirect()->route('admin.pembimbing.index')->with('status', 'Data pembimbing berhasil diperbarui.');
    }

    public function destroy(Pembimbing $pembimbing)
    {
        $pembimbing->delete();

        return redirect()->route('admin.pembimbing.index')->with('status', 'Data pembimbing berhasil dihapus.');
    }
}
