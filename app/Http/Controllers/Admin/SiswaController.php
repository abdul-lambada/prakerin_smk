<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pembimbing;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            // Menggunakan PhpSpreadsheet untuk Excel
            try {
                $spreadsheet = IOFactory::load($path);
            } catch (\Throwable $e) {
                return redirect()->back()->with('error', 'Gagal membaca file Excel: '.$e->getMessage());
            }

            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            // Asumsi baris 1 adalah header, mulai dari baris 2
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, null, true, true, true)[0];
                // Ambil kolom A-E sebagai [nis, nama, kd_kelas, kd_pembimbing, telp]
                $rows[] = [
                    $rowData['A'] ?? null,
                    $rowData['B'] ?? null,
                    $rowData['C'] ?? null,
                    $rowData['D'] ?? null,
                    $rowData['E'] ?? null,
                ];
            }
        }

        $imported = 0;

        foreach ($rows as $row) {
            if (count($row) < 5) {
                continue;
            }

            [$nis, $namaLengkap, $kdKelas, $kdPembimbing, $telp] = $row;

            if (! $nis || ! $namaLengkap || ! $kdKelas || ! $kdPembimbing) {
                continue;
            }

            $nis = trim((string) $nis);
            $namaLengkap = trim((string) $namaLengkap);

            // Buat / ambil user siswa
            $user = User::firstOrCreate(
                ['username' => $nis],
                [
                    'name'      => $namaLengkap,
                    'identitas' => $nis,
                    'role'      => 'siswa',
                    // cast hashed akan meng-hash otomatis
                    'password'  => (string) $nis,
                ]
            );

            // Buat / update data siswa
            Siswa::updateOrCreate(
                ['nis_siswa' => $nis],
                [
                    'user_id'       => $user->id,
                    'kd_kelas'      => $kdKelas,
                    'kd_pembimbing' => $kdPembimbing,
                    'nama_lengkap'  => $namaLengkap,
                    'telp'          => $telp,
                ]
            );

            $imported++;
        }

        return redirect()->route('admin.siswa.index')
            ->with('status', "Import selesai. Data siswa yang diproses: {$imported}.");
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'nis_siswa');
        $sheet->setCellValue('B1', 'nama_lengkap');
        $sheet->setCellValue('C1', 'kd_kelas');
        $sheet->setCellValue('D1', 'kd_pembimbing');
        $sheet->setCellValue('E1', 'telp');

        $writer = new Xlsx($spreadsheet);

        $fileName = 'template-import-siswa.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
}
