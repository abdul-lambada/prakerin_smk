<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_info', function (Blueprint $table) {
            $table->increments('kd_info');
            $table->unsignedBigInteger('user_id');
            $table->string('judul', 100);
            $table->text('isi');
            $table->date('tanggal');
            $table->string('kategori', 50)->nullable();
            $table->text('file')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_info');
    }
};
