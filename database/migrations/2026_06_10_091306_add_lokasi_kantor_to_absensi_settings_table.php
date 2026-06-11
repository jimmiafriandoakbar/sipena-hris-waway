<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi_settings', function (Blueprint $table) {
            $table->decimal('latitude_kantor', 10, 7)->nullable()->after('radius_absensi');
            $table->decimal('longitude_kantor', 10, 7)->nullable()->after('latitude_kantor');
        });
    }

    public function down(): void
    {
        Schema::table('absensi_settings', function (Blueprint $table) {
            $table->dropColumn([
                'latitude_kantor',
                'longitude_kantor',
            ]);
        });
    }
};