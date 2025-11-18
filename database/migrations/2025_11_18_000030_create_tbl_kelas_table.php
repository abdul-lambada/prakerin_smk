<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_kelas', function (Blueprint $table) {
            $table->increments('kd_kelas');
            $table->unsignedInteger('kd_jurusan');
            $table->string('nama', 20);

            $table->foreign('kd_jurusan')
                ->references('kd_jurusan')
                ->on('tbl_jurusan')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_kelas');
    }
};
