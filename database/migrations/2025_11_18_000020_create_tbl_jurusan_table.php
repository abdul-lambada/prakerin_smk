<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_jurusan', function (Blueprint $table) {
            $table->increments('kd_jurusan');
            $table->string('nama', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_jurusan');
    }
};
