<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Monitoring::with(['tempat.industri', 'tempat.siswa', 'tempat.pembimbing']);

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->input('tahun'));
        }

        $monitorings = $query->orderByDesc('tanggal')->get();

        $years = Monitoring::selectRaw('YEAR(tanggal) as year')
            ->whereNotNull('tanggal')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year');

        return view('admin.monitoring.index', compact('monitorings', 'years'));
    }
}
