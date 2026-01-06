<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
        ]);

        $path = $request->file('file')->getRealPath();
        $extension = strtolower($request->file('file')->getClientOriginalExtension());

        $rows = [];

        if (in_array($extension, ['csv', 'txt'], true)) {
            $handle = fopen($path, 'r');
            if (! $handle) {
                return redirect()->back()->with('error', 'Tidak dapat membaca file yang diupload.');
            }

            // Baris pertama header
            $header = fgetcsv($handle, 0, ',');

            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                $rows[] = $row;
            }

            fclose($handle);
        } else {
            try {
                $spreadsheet = IOFactory::load($path);
            } catch (\Throwable $e) {
                return redirect()->back()->with('error', 'Gagal membaca file Excel: '.$e->getMessage());
            }

            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            // Asumsi baris 1 header, mulai dari baris 2
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, null, true, true, true)[0];
                // Kolom A-D: NIP, Nama Lengkap, KD Jurusan, Wilayah
                $rows[] = [
                    $rowData['A'] ?? null,
                    $rowData['B'] ?? null,
                    $rowData['C'] ?? null,
                    $rowData['D'] ?? null,
                ];
            }
        }

        $imported = 0;

        foreach ($rows as $row) {
            if (count($row) < 4) {
                continue;
            }

            [$nip, $namaLengkap, $kdJurusan, $wilayah] = $row;

            if (! $nip || ! $namaLengkap || ! $kdJurusan) {
                continue;
            }

            $nip = trim((string) $nip);
            $namaLengkap = trim((string) $namaLengkap);

            // Buat / ambil user pembimbing
            $user = User::firstOrCreate(
                ['username' => $nip],
                [
                    'name'      => $namaLengkap,
                    'identitas' => $nip,
                    'role'      => 'pembimbing',
                    'password'  => (string) $nip,
                ]
            );

            // Buat / update data pembimbing
            Pembimbing::updateOrCreate(
                ['nip' => $nip],
                [
                    'user_id'      => $user->id,
                    'kd_jurusan'   => $kdJurusan,
                    'nama_lengkap' => $namaLengkap,
                    'wilayah'      => $wilayah,
                ]
            );

            $imported++;
        }

        return redirect()->route('admin.pembimbing.index')
            ->with('status', "Import selesai. Data pembimbing yang diproses: {$imported}.");
    }

    public function downloadTemplate()
    {
        $content = "nip,nama_lengkap,kd_jurusan,wilayah\n";

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template-import-pembimbing.csv"',
        ]);
    }
}
