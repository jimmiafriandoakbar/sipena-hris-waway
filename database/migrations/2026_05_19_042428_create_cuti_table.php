<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuti', function (Blueprint $table) {

            $table->id();

            $table->foreignId('surat_id')
                ->constrained('surat')
                ->onDelete('cascade');

            $table->foreignId('pegawai_id');

            $table->string('jenis_cuti');

            $table->date('mulai_cuti');

            $table->date('akhir_cuti');

            $table->integer('total_hari');

            $table->text('keterangan')->nullable();

            $table->text('alamat')->nullable();

            $table->string('nomor_hp')->nullable();

            $table->string('user_cbs')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};