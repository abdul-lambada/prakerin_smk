<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username'  => 'admin',
                'name'      => 'Administrator',
                'identitas' => 'admin',
                'role'      => 'admin',
                'password'  => Hash::make('password'),
                'foto'      => null,
            ]
        );

        // Contoh user pembimbing
        User::updateOrCreate(
            ['email' => 'pembimbing@example.com'],
            [
                'username'  => 'pembimbing1',
                'name'      => 'Pembimbing Satu',
                'identitas' => '0215151554',
                'role'      => 'pembimbing',
                'password'  => Hash::make('password'),
                'foto'      => null,
            ]
        );

        // Contoh user siswa
        User::updateOrCreate(
            ['email' => 'siswa@example.com'],
            [
                'username'  => 'siswa1',
                'name'      => 'Siswa Satu',
                'identitas' => '123654',
                'role'      => 'siswa',
                'password'  => Hash::make('password'),
                'foto'      => null,
            ]
        );
    }
}
