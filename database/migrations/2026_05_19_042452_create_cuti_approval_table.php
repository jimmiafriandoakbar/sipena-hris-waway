<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuti_approval', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cuti_id')
                ->constrained('cuti')
                ->onDelete('cascade');

            $table->foreignId('pegawai_id');

            // urutan approval
            $table->integer('urutan');

            // backup / kabag / sdm / dir_ops / dirut
            $table->string('role_approval');

            // pending / disetujui / ditolak
            $table->string('status')
                ->default('pending');

            $table->text('catatan')
                ->nullable();

            $table->timestamp('tanggal_approval')
                ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuti_approval');
    }
};