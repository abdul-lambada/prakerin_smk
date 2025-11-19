<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_bimbingan', function (Blueprint $table) {
            $table->boolean('is_read_siswa')->default(false)->after('file');
            $table->boolean('is_read_pembimbing')->default(false)->after('is_read_siswa');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_bimbingan', function (Blueprint $table) {
            $table->dropColumn(['is_read_siswa', 'is_read_pembimbing']);
        });
    }
};
