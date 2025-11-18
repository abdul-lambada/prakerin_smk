<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_tempat', function (Blueprint $table) {
            $table->increments('kd_tempat');
            $table->unsignedInteger('nis_siswa');
            $table->unsignedInteger('kd_pembimbing');
            $table->unsignedInteger('kd_industri');
            $table->date('tanggal');
            $table->string('wilayah', 50);
            $table->year('tahun');
            $table->enum('status', ['-', 'proses', 'ditolak', 'diterima']);
            $table->text('surat');

            $table->foreign('nis_siswa')->references('nis_siswa')->on('tbl_siswa')->onDelete('cascade');
            $table->foreign('kd_pembimbing')->references('kd_pembimbing')->on('tbl_pembimbing')->onDelete('cascade');
            $table->foreign('kd_industri')->references('kd_industri')->on('tbl_industri')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_tempat');
    }
};
