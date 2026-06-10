<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_ttd', function (Blueprint $table) {

            $table->id();

            $table->foreignId('surat_id')
                ->constrained('surat')
                ->onDelete('cascade');

            $table->foreignId('pegawai_id')
                ->constrained('pegawai')
                ->onDelete('cascade');

            $table->integer('urutan')->default(1);

            $table->string('status')
                ->default('pending');

            $table->timestamp('tanggal_ttd')
                ->nullable();

            $table->text('catatan')
                ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_ttd');
    }
};