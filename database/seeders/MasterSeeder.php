<?php

namespace Database\Seeders;

use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Pembimbing;
use App\Models\Siswa;
use App\Models\Tempat;
use App\Models\User;
use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        // Jurusan
        $tkro = Jurusan::updateOrCreate(['kd_jurusan' => 2], ['nama' => 'TKRO']);
        $tkj  = Jurusan::updateOrCreate(['kd_jurusan' => 3], ['nama' => 'TKJ']);
        $akl  = Jurusan::updateOrCreate(['kd_jurusan' => 4], ['nama' => 'AKL']);

        // Kelas
        $kelasXiiB = Kelas::updateOrCreate(['kd_kelas' => 2], [
            'kd_jurusan' => $tkj->kd_jurusan,
            'nama'       => 'XII-B',
        ]);
        $kelasXiiC = Kelas::updateOrCreate(['kd_kelas' => 3], [
            'kd_jurusan' => $tkro->kd_jurusan,
            'nama'       => 'XII-C',
        ]);
        $kelasXiiA = Kelas::updateOrCreate(['kd_kelas' => 4], [
            'kd_jurusan' => $akl->kd_jurusan,
            'nama'       => 'XII-A',
        ]);

        // Industri
        $astra = Industri::updateOrCreate(['kd_industri' => 2], [
            'nama_industri'  => 'Astra 2000',
            'bidang_kerja'   => 'Otomotif',
            'deskripsi'      => 'Bengkel Mobil',
            'alamat_industri'=> 'Karawang',
            'wilayah'        => 'Karawang, Jawa Barat',
            'telepon'        => '45574865522',
            'kuota'          => 5,
            'foto'           => 'astra-new.png',
        ]);

        // Ambil user pembimbing & siswa dari UserSeeder
        $userPembimbing = User::where('email', 'pembimbing@example.com')->first();
        $userSiswa      = User::where('email', 'siswa@example.com')->first();

        // Pembimbing
        $pembimbing = Pembimbing::updateOrCreate(['kd_pembimbing' => 8], [
            'user_id'      => optional($userPembimbing)->id,
            'kd_jurusan'   => (string) $akl->kd_jurusan,
            'nip'          => '0215151554',
            'nama_lengkap' => 'Abdul kholik',
            'wilayah'      => 'Majalengka',
        ]);

        // Siswa
        $siswa = Siswa::updateOrCreate(['nis_siswa' => 123654], [
            'kd_kelas'     => $kelasXiiA->kd_kelas,
            'user_id'      => optional($userSiswa)->id,
            'nama_lengkap' => 'Abdul Ajis',
            'telp'         => '02165489485132',
            'foto'         => 'user-siswa7.png',
            'kd_pembimbing'=> $pembimbing->kd_pembimbing,
        ]);

        // Tempat PKL dasar
        Tempat::updateOrCreate(['kd_tempat' => 7], [
            'nis_siswa'    => $siswa->nis_siswa,
            'kd_pembimbing'=> $pembimbing->kd_pembimbing,
            'kd_industri'  => $astra->kd_industri,
            'tanggal'      => '2023-08-03',
            'wilayah'      => 'Majalengka, Jawa Barat',
            'tahun'        => 2023,
            'status'       => 'diterima',
            'surat'        => 'UTS_Abdul_Kholik_200510011_Analisis_Strategi_Algoritma_D3_TIF28.pdf',
        ]);
    }
}
