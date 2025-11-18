<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_siswa', function (Blueprint $table) {
            $table->increments('nis_siswa');
            $table->unsignedInteger('kd_kelas');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_lengkap', 500);
            $table->string('telp', 14);
            $table->text('foto');
            $table->unsignedInteger('kd_pembimbing');

            $table->foreign('kd_kelas')
                ->references('kd_kelas')
                ->on('tbl_kelas')
                ->onDelete('cascade');

            $table->foreign('kd_pembimbing')
                ->references('kd_pembimbing')
                ->on('tbl_pembimbing')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_siswa');
    }
};
