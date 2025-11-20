<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_chat_dudi_pembimbing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_user_id');
            $table->unsignedBigInteger('to_user_id');
            $table->enum('kategori', ['kritik_saran', 'monitoring_siswa']);
            $table->string('judul', 100)->nullable();
            $table->text('pesan');
            $table->unsignedInteger('kd_tempat')->nullable();
            $table->boolean('is_read_dudi')->default(false);
            $table->boolean('is_read_pembimbing')->default(false);
            $table->timestamps();

            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kd_tempat')->references('kd_tempat')->on('tbl_tempat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_chat_dudi_pembimbing');
    }
};
