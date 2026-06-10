<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('jenis_surat');

            $table->string('nomor_surat')->nullable();

            $table->date('tanggal_surat')->nullable();

            $table->string('perihal');

            $table->longText('isi_surat')->nullable();

            $table->string('file_pdf')->nullable();

            $table->string('status')->default('draft');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};