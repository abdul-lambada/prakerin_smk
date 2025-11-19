<?php

namespace App\Http\Controllers;

use App\Models\Info;

class PembimbingInfoController extends Controller
{
    public function index()
    {
        $infos = Info::with('user')->latest('tanggal')->get();
        return view('pembimbing.info.index', compact('infos'));
    }
}
