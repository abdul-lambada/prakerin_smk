<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_nilai', function (Blueprint $table) {
            // nilai dari DU/DI dan Sidang, 0-100
            $table->decimal('nilai_du_di', 5, 2)->nullable()->after('nilai');
            $table->decimal('nilai_sidang', 5, 2)->nullable()->after('nilai_du_di');

            // bobot dalam persen, default 60/40
            $table->unsignedTinyInteger('bobot_du_di')->default(60)->after('nilai_sidang');
            $table->unsignedTinyInteger('bobot_sidang')->default(40)->after('bobot_du_di');

            // nilai akhir dan predikat
            $table->decimal('nilai_akhir', 5, 2)->nullable()->after('bobot_sidang');
            $table->string('predikat', 5)->nullable()->after('nilai_akhir');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_nilai', function (Blueprint $table) {
            $table->dropColumn([
                'nilai_du_di',
                'nilai_sidang',
                'bobot_du_di',
                'bobot_sidang',
                'nilai_akhir',
                'predikat',
            ]);
        });
    }
};
