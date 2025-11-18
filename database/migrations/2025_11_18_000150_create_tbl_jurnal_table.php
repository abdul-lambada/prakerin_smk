<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_jurnal', function (Blueprint $table) {
            $table->increments('kd_jurnal');
            $table->unsignedInteger('nis_siswa');
            $table->unsignedInteger('kd_tempat');
            $table->date('tanggal');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('kegiatan', 100);
            $table->text('deskripsi')->nullable();

            $table->foreign('nis_siswa')->references('nis_siswa')->on('tbl_siswa')->onDelete('cascade');
            $table->foreign('kd_tempat')->references('kd_tempat')->on('tbl_tempat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_jurnal');
    }
};
