<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pembimbing;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['user', 'kelas.jurusan', 'pembimbing.user'])->get();

        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::with('jurusan')->get();
        $pembimbings = Pembimbing::with('user')->get();
        $users = User::where('role', 'siswa')->get();

        return view('admin.siswa.create', compact('kelas', 'pembimbings', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis_siswa'     => 'required|integer|unique:tbl_siswa,nis_siswa',
            'user_id'       => 'required|exists:users,id',
            'kd_kelas'      => 'required|exists:tbl_kelas,kd_kelas',
            'kd_pembimbing' => 'required|exists:tbl_pembimbing,kd_pembimbing',
            'nama_lengkap'  => 'required|string|max:500',
            'telp'          => 'required|string|max:14',
        ]);

        Siswa::create($data + ['foto' => $request->input('foto', '')]);

        return redirect()->route('admin.siswa.index')->with('status', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::with('jurusan')->get();
        $pembimbings = Pembimbing::with('user')->get();

        return view('admin.siswa.edit', compact('siswa', 'kelas', 'pembimbings'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'kd_kelas'      => 'required|exists:tbl_kelas,kd_kelas',
            'kd_pembimbing' => 'required|exists:tbl_pembimbing,kd_pembimbing',
            'nama_lengkap'  => 'required|string|max:500',
            'telp'          => 'required|string|max:14',
        ]);

        $siswa->update($data);

        return redirect()->route('admin.siswa.index')->with('status', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('status', 'Data siswa berhasil dihapus.');
    }
}
