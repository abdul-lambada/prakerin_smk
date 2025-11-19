<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('profile.index', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name'  => 'sometimes|string|max:50',
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Tambahan sesuai role
        if ($user->role === 'pembimbing') {
            $rules['wilayah'] = 'nullable|string|max:50';
        } elseif ($user->role === 'siswa') {
            $rules['telp'] = 'nullable|string|max:14';
        }

        $data = $request->validate($rules);

        // Update field User dasar di sini (name)
        $user->name = $data['name'] ?? $user->name;

        // Jika ada upload foto, simpan file dan update path foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('profile_photos', 'public');
            $user->foto = $path;
        }

        $user->save();

        // Update detail berdasarkan role
        if ($user->role === 'pembimbing' && array_key_exists('wilayah', $data)) {
            if ($user->pembimbing) {
                $user->pembimbing->update([
                    'wilayah' => $data['wilayah'],
                ]);
            }
        } elseif ($user->role === 'siswa' && array_key_exists('telp', $data)) {
            if ($user->siswa) {
                $user->siswa->update([
                    'telp' => $data['telp'],
                ]);
            }
        }

        return redirect()->route('profile.show')->with('status', 'Profil berhasil diperbarui.');
    }
}
