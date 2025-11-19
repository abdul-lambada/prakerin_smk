<?php

namespace App\Http\Controllers;

use App\Models\Info;

class SiswaInfoController extends Controller
{
    public function index()
    {
        $infos = Info::with('user')->latest('tanggal')->get();
        return view('siswa.info.index', compact('infos'));
    }
}
