<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lembur', function (Blueprint $table) {

            $table->id();

            $table->foreignId('surat_id')
                ->constrained('surat')
                ->onDelete('cascade');

            $table->string('nama_pengaju');

            $table->string('jabatan_pengaju');

            $table->text('pekerjaan');

            $table->string('area');

            $table->date('tanggal_lembur');

            $table->string('jam_lembur');

            $table->integer('jumlah_tenaga');

            $table->text('pegawai_lembur');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lembur');
    }
};