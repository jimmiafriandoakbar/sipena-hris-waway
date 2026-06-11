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
        Schema::create('absensis', function (Blueprint $table) {

            $table->id();

            $table->foreignId('pegawai_id')
                ->constrained('pegawai')
                ->cascadeOnDelete();

            $table->date('tanggal');
            $table->string('nama_hari')->nullable();

            // Check In
            $table->time('jam_masuk')->nullable();
            $table->decimal('latitude_masuk', 10, 7)->nullable();
            $table->decimal('longitude_masuk', 10, 7)->nullable();
            $table->decimal('jarak_masuk', 10, 2)->nullable();
            $table->boolean('valid_lokasi_masuk')->default(true);
            $table->string('foto_masuk')->nullable();

            // Check Out
            $table->time('jam_pulang')->nullable();
            $table->decimal('latitude_pulang', 10, 7)->nullable();
            $table->decimal('longitude_pulang', 10, 7)->nullable();
            $table->decimal('jarak_pulang', 10, 2)->nullable();
            $table->boolean('valid_lokasi_pulang')->default(true);
            $table->string('foto_pulang')->nullable();

            // Status
            $table->enum('status_masuk', [
                'hadir',
                'terlambat'
            ])->default('hadir');

            $table->enum('status_pulang', [
                'normal',
                'pulang_cepat',
                'tidak_absen_pulang'
            ])->default('normal');

            // Perhitungan
            $table->integer('menit_terlambat')->default(0);
            $table->integer('menit_pulang_cepat')->default(0);
            $table->integer('total_menit_lembur')->default(0);

            // Informasi Device
            $table->string('ip_address')->nullable();
            $table->text('device')->nullable();

            $table->timestamps();

            // Satu pegawai hanya boleh 1 absensi per hari
            $table->unique(['pegawai_id', 'tanggal']);

            // Untuk mempercepat rekap bulanan
            $table->index('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};