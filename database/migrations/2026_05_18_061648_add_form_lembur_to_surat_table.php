<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat', function (Blueprint $table) {

            $table->string('nama_pengaju')
                ->nullable();

            $table->string('jabatan_pengaju')
                ->nullable();

            $table->text('pekerjaan')
                ->nullable();

            $table->string('area')
                ->nullable();

            $table->date('tanggal_lembur')
                ->nullable();

            $table->string('jam_lembur')
                ->nullable();

            $table->integer('jumlah_tenaga')
                ->nullable();

            $table->text('pegawai_lembur')
                ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {

            $table->dropColumn([

                'nama_pengaju',
                'jabatan_pengaju',
                'pekerjaan',
                'area',
                'tanggal_lembur',
                'jam_lembur',
                'jumlah_tenaga',
                'pegawai_lembur'

            ]);

        });
    }
};