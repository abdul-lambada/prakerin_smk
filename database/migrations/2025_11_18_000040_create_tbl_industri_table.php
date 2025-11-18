<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_industri', function (Blueprint $table) {
            $table->increments('kd_industri');
            $table->string('nama_industri', 50);
            $table->string('bidang_kerja', 50);
            $table->text('deskripsi');
            $table->text('alamat_industri');
            $table->string('wilayah', 50);
            $table->string('telepon', 20);
            $table->integer('kuota');
            $table->text('foto');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_industri');
    }
};
