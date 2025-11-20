<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum role agar menambahkan nilai 'dudi'
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','pembimbing','siswa','dudi') NOT NULL DEFAULT 'siswa'");
    }

    public function down(): void
    {
        // Kembalikan ke enum awal tanpa 'dudi'
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','pembimbing','siswa') NOT NULL DEFAULT 'siswa'");
    }
};
