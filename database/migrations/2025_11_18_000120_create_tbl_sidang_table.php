<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_sidang', function (Blueprint $table) {
            $table->increments('kd_sidang');
            $table->unsignedInteger('nis_siswa');
            $table->unsignedInteger('kd_tempat');
            $table->unsignedInteger('kd_industri');
            $table->text('judul');
            $table->text('file');

            $table->foreign('nis_siswa')->references('nis_siswa')->on('tbl_siswa')->onDelete('cascade');
            $table->foreign('kd_tempat')->references('kd_tempat')->on('tbl_tempat')->onDelete('cascade');
            $table->foreign('kd_industri')->references('kd_industri')->on('tbl_industri')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_sidang');
    }
};
