<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 32)->nullable()->after('id');
            $table->string('name', 50)->change();
            $table->string('identitas', 32)->nullable()->after('email');
            $table->enum('role', ['admin', 'pembimbing', 'siswa'])->default('siswa')->after('password');
            $table->text('foto')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'identitas', 'role', 'foto']);
        });
    }
};
