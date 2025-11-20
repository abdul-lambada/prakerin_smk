<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Pembimbing;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembimbingMonitoringLapanganController extends Controller
{
    public function index()
    {
        $pembimbing = $this->getPembimbing();

        $monitorings = Monitoring::with('tempat.industri')
            ->whereIn('kd_tempat', function ($q) use ($pembimbing) {
                $q->select('kd_tempat')
                  ->from('tbl_tempat')
                  ->where('kd_pembimbing', $pembimbing->kd_pembimbing);
            })
            ->orderByDesc('tanggal')
            ->get();

        return view('pembimbing.monitoring_lapangan.index', compact('pembimbing', 'monitorings'));
    }

    public function create()
    {
        $pembimbing = $this->getPembimbing();

        $tempats = Tempat::with('industri')
            ->where('kd_pembimbing', $pembimbing->kd_pembimbing)
            ->orderByDesc('tanggal')
            ->get();

        return view('pembimbing.monitoring_lapangan.create', compact('pembimbing', 'tempats'));
    }

    public function store(Request $request)
    {
        $pembimbing = $this->getPembimbing();

        $data = $request->validate([
            'kd_tempat' => 'required|exists:tbl_tempat,kd_tempat',
            'tanggal'   => 'required|date',
            'catatan'   => 'nullable|string',
            'foto'      => 'nullable|image|max:2048',
        ]);

        // Pastikan tempat milik pembimbing ini
        $tempatValid = Tempat::where('kd_tempat', $data['kd_tempat'])
            ->where('kd_pembimbing', $pembimbing->kd_pembimbing)
            ->exists();

        if (! $tempatValid) {
            abort(403, 'Tempat PKL tidak valid untuk pembimbing ini.');
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('monitoring', 'public');
        }

        Monitoring::create($data);

        return redirect()->route('pembimbing.monitoring-lapangan.index')->with('status', 'Catatan monitoring berhasil disimpan.');
    }

    public function edit(Monitoring $monitoring)
    {
        $pembimbing = $this->getPembimbing();

        $this->authorizeMonitoring($monitoring, $pembimbing);

        $tempats = Tempat::with('industri')
            ->where('kd_pembimbing', $pembimbing->kd_pembimbing)
            ->orderByDesc('tanggal')
            ->get();

        return view('pembimbing.monitoring_lapangan.edit', compact('pembimbing', 'monitoring', 'tempats'));
    }

    public function update(Request $request, Monitoring $monitoring)
    {
        $pembimbing = $this->getPembimbing();
        $this->authorizeMonitoring($monitoring, $pembimbing);

        $data = $request->validate([
            'kd_tempat' => 'required|exists:tbl_tempat,kd_tempat',
            'tanggal'   => 'required|date',
            'catatan'   => 'nullable|string',
            'foto'      => 'nullable|image|max:2048',
        ]);

        $tempatValid = Tempat::where('kd_tempat', $data['kd_tempat'])
            ->where('kd_pembimbing', $pembimbing->kd_pembimbing)
            ->exists();

        if (! $tempatValid) {
            abort(403, 'Tempat PKL tidak valid untuk pembimbing ini.');
        }

        if ($request->hasFile('foto')) {
            if ($monitoring->foto) {
                Storage::disk('public')->delete($monitoring->foto);
            }
            $data['foto'] = $request->file('foto')->store('monitoring', 'public');
        }

        $monitoring->update($data);

        return redirect()->route('pembimbing.monitoring-lapangan.index')->with('status', 'Catatan monitoring berhasil diperbarui.');
    }

    public function destroy(Monitoring $monitoring)
    {
        $pembimbing = $this->getPembimbing();
        $this->authorizeMonitoring($monitoring, $pembimbing);

        if ($monitoring->foto) {
            Storage::disk('public')->delete($monitoring->foto);
        }

        $monitoring->delete();

        return redirect()->route('pembimbing.monitoring-lapangan.index')->with('status', 'Catatan monitoring berhasil dihapus.');
    }

    protected function getPembimbing(): Pembimbing
    {
        $user = Auth::user();

        return Pembimbing::where('user_id', $user->id)->firstOrFail();
    }

    protected function authorizeMonitoring(Monitoring $monitoring, Pembimbing $pembimbing): void
    {
        $allowed = Tempat::where('kd_tempat', $monitoring->kd_tempat)
            ->where('kd_pembimbing', $pembimbing->kd_pembimbing)
            ->exists();

        if (! $allowed) {
            abort(403, 'Anda tidak berwenang mengelola catatan monitoring ini.');
        }
    }
}
