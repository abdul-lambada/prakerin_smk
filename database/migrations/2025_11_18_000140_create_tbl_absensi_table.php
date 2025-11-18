<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_absensi', function (Blueprint $table) {
            $table->increments('kd_absensi');
            $table->unsignedInteger('nis_siswa');
            $table->unsignedInteger('kd_tempat');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']);
            $table->text('keterangan')->nullable();

            $table->foreign('nis_siswa')->references('nis_siswa')->on('tbl_siswa')->onDelete('cascade');
            $table->foreign('kd_tempat')->references('kd_tempat')->on('tbl_tempat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_absensi');
    }
};
