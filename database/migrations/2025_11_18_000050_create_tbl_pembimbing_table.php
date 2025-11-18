<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_pembimbing', function (Blueprint $table) {
            $table->increments('kd_pembimbing');
            $table->unsignedBigInteger('user_id');
            $table->char('kd_jurusan', 5);
            $table->char('nip', 21);
            $table->string('nama_lengkap', 50);
            $table->string('wilayah', 50);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_pembimbing');
    }
};
