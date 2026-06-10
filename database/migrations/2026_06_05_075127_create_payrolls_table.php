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
    Schema::create('payrolls', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pegawai_id')
            ->constrained('pegawai')
            ->cascadeOnDelete();

        $table->decimal('gaji_pokok', 15, 2)->default(0);
        $table->decimal('tunjangan_teller', 15, 2)->default(0);
        $table->decimal('tunjangan_anak', 15, 2)->default(0);
        $table->integer('jumlah_anak')->default(0);
        $table->decimal('tunjangan_istri', 15, 2)->default(0);
        $table->decimal('tunjangan_kemahalan', 15, 2)->default(0);
        $table->decimal('tunjangan_lain_lain', 15, 2)->default(0);

        $table->decimal('koperasi', 15, 2)->default(0);
        $table->decimal('infaq', 15, 2)->default(0);
        $table->decimal('bpjs_kesehatan', 15, 2)->default(0);
        $table->decimal('tabungan_pensiun', 15, 2)->default(0);
        $table->decimal('bpjs_ketenagakerjaan', 15, 2)->default(0);
        $table->decimal('pinjaman_pegawai', 15, 2)->default(0);
        $table->decimal('potongan_lain_lain', 15, 2)->default(0);

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('payrolls');
}
};
