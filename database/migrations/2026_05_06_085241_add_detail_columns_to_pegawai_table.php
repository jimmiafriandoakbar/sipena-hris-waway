<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {

            $table->string('pendidikan')->nullable();
            $table->string('jurusan')->nullable();
            $table->date('mulai_bekerja')->nullable();
            $table->string('nomor_rekening')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {

            $table->dropColumn([
                'pendidikan',
                'jurusan',
                'mulai_bekerja',
                'nomor_rekening'
            ]);

        });
    }
};