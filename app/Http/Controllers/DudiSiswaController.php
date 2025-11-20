<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use Illuminate\Support\Facades\Auth;

class DudiSiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $industri = Industri::with(['tempat.siswa'])
            ->where('user_id', $user->id)
            ->first();

        $tempats = $industri ? $industri->tempat : collect();

        return view('dudi.siswa.index', compact('industri', 'tempats'));
    }
}
