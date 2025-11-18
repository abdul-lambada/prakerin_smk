<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Bimbingan;
use App\Models\Jurnal;
use App\Models\Laporan;
use App\Models\Nilai;
use App\Models\Sidang;
use App\Models\Tempat;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $siswa  = Siswa::where('nis_siswa', 123654)->first();
        $tempat = Tempat::where('kd_tempat', 7)->first();

        if (! $siswa || ! $tempat) {
            return;
        }

        // Bimbingan
        Bimbingan::updateOrCreate(['kd_bimbingan' => 4], [
            'kd_tempat' => $tempat->kd_tempat,
            'nip'       => '0215151554',
            'nis_siswa' => $siswa->nis_siswa,
            'tanggal'   => '2023-08-04',
            'judul'     => 'SISFO',
            'catatan'   => 'ok',
            'file'      => 'lampiran/bimbingan/UTS_Abdul_Kholik_200510011_Analisis_Strategi_Algoritma_D3_TIF2.pdf',
        ]);

        Bimbingan::updateOrCreate(['kd_bimbingan' => 11], [
            'kd_tempat' => $tempat->kd_tempat,
            'nip'       => '0215151554',
            'nis_siswa' => $siswa->nis_siswa,
            'tanggal'   => '2023-08-04',
            'judul'     => 'SISFO',
            'catatan'   => 'okkkkkkkkkk',
            'file'      => 'lampiran/bimbingan_siswa/Bukti_Pendaftaran_Abdul_kholik_Junior_Network_Administrator.pdf',
        ]);

        Bimbingan::updateOrCreate(['kd_bimbingan' => 12], [
            'kd_tempat' => $tempat->kd_tempat,
            'nip'       => '0215151554',
            'nis_siswa' => $siswa->nis_siswa,
            'tanggal'   => '2023-08-05',
            'judul'     => 'SISFO',
            'catatan'   => 'okkkknchecygycg',
            'file'      => 'lampiran/bimbingan_siswa/Silabus_Junior_Network_Administrator.pdf',
        ]);

        // Laporan
        Laporan::updateOrCreate(['kd_laporan' => 3], [
            'nis_siswa' => $siswa->nis_siswa,
            'kd_tempat' => $tempat->kd_tempat,
            'kd_industri' => $tempat->kd_industri,
            'judul'     => 'SISFO',
            'file'      => 'lampiran/laporan_siswa/457-Article_Text-956-1-10-202209011.pdf',
        ]);

        Laporan::updateOrCreate(['kd_laporan' => 4], [
            'nis_siswa' => $siswa->nis_siswa,
            'kd_tempat' => $tempat->kd_tempat,
            'kd_industri' => $tempat->kd_industri,
            'judul'     => 'SISFO',
            'file'      => 'lampiran/laporan_siswa/UTS_Abdul_Kholik_200510011_Analisis_Strategi_Algoritma_D3_TIF.pdf',
        ]);

        // Nilai
        Nilai::updateOrCreate(['kd_nilai' => 1], [
            'kd_tempat'  => $tempat->kd_tempat,
            'keterangan' => 'lulus',
            'nilai'      => 90,
        ]);

        Nilai::updateOrCreate(['kd_nilai' => 2], [
            'kd_tempat'  => $tempat->kd_tempat,
            'keterangan' => 'lulus',
            'nilai'      => 85,
        ]);

        // Sidang
        Sidang::updateOrCreate(['kd_sidang' => 14], [
            'nis_siswa'  => $siswa->nis_siswa,
            'kd_tempat'  => $tempat->kd_tempat,
            'kd_industri'=> $tempat->kd_industri,
            'judul'      => 'SISFO',
            'file'       => 'lampiran/sidang_siswa/Silabus_Junior_Network_Administrator1.pdf',
        ]);

        // Absensi contoh
        Absensi::updateOrCreate(['kd_absensi' => 1], [
            'nis_siswa'  => $siswa->nis_siswa,
            'kd_tempat'  => $tempat->kd_tempat,
            'tanggal'    => '2023-08-04',
            'jam_masuk'  => '08:00:00',
            'jam_keluar' => '16:00:00',
            'status'     => 'hadir',
            'keterangan' => 'Hari pertama PKL',
        ]);

        Absensi::updateOrCreate(['kd_absensi' => 2], [
            'nis_siswa'  => $siswa->nis_siswa,
            'kd_tempat'  => $tempat->kd_tempat,
            'tanggal'    => '2023-08-05',
            'jam_masuk'  => '08:05:00',
            'jam_keluar' => '16:00:00',
            'status'     => 'hadir',
            'keterangan' => 'Sedikit terlambat',
        ]);

        // Jurnal contoh
        Jurnal::updateOrCreate(['kd_jurnal' => 1], [
            'nis_siswa'   => $siswa->nis_siswa,
            'kd_tempat'   => $tempat->kd_tempat,
            'tanggal'     => '2023-08-04',
            'jam_mulai'   => '08:00:00',
            'jam_selesai' => '12:00:00',
            'kegiatan'    => 'Memasang Monitor',
            'deskripsi'   => 'Belajar memasang monitor komputer pada beberapa unit.',
        ]);

        Jurnal::updateOrCreate(['kd_jurnal' => 2], [
            'nis_siswa'   => $siswa->nis_siswa,
            'kd_tempat'   => $tempat->kd_tempat,
            'tanggal'     => '2023-08-05',
            'jam_mulai'   => '13:00:00',
            'jam_selesai' => '16:00:00',
            'kegiatan'    => 'Pengecekan CPU',
            'deskripsi'   => 'Melakukan pengecekan CPU dan membersihkan bagian dalam casing.',
        ]);
    }
}
