<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_tolak_tempat', function (Blueprint $table) {
            $table->increments('kd_tolak');
            $table->unsignedInteger('kd_tempat');
            $table->date('tanggal');
            $table->text('alasan');

            $table->foreign('kd_tempat')->references('kd_tempat')->on('tbl_tempat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_tolak_tempat');
    }
};
