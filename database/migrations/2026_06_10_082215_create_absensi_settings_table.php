<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi_settings', function (Blueprint $table) {
    $table->id();

    $table->time('jam_masuk')->default('08:00:00');
    $table->time('jam_pulang')->default('16:30:00');
    $table->time('jam_mulai_lembur')->default('17:00:00');

    $table->integer('toleransi_terlambat')->default(15);
    $table->integer('radius_absensi')->default(100);

    $table->json('hari_kerja')->nullable();

    $table->boolean('wajib_foto')->default(true);
    $table->boolean('wajib_lokasi')->default(true);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_settings');
    }
};
