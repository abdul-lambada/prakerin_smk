<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_bimbingan', function (Blueprint $table) {
            $table->increments('kd_bimbingan');
            $table->unsignedInteger('kd_tempat');
            $table->char('nip', 21);
            $table->unsignedInteger('nis_siswa');
            $table->date('tanggal');
            $table->string('judul', 50);
            $table->text('catatan');
            $table->text('file');

            $table->foreign('kd_tempat')->references('kd_tempat')->on('tbl_tempat')->onDelete('cascade');
            $table->foreign('nis_siswa')->references('nis_siswa')->on('tbl_siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_bimbingan');
    }
};
