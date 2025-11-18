<?php

namespace Database\Seeders;

use App\Models\Info;
use App\Models\User;
use Illuminate\Database\Seeder;

class InfoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        if (! $admin) {
            return;
        }

        Info::updateOrCreate([
            'kd_info' => 1,
        ], [
            'user_id'  => $admin->id,
            'judul'    => 'Pengumuman PKL',
            'isi'      => 'Selamat datang di sistem PKL. Silakan lengkapi data siswa dan tempat PKL.',
            'tanggal'  => now()->toDateString(),
            'kategori' => 'pkl',
            'file'     => null,
        ]);
    }
}
