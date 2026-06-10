<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cuti_approval', function (Blueprint $table) {

            // kepala bagian / dirut
            $table->date('cuti_efektif')
                ->nullable();

            $table->date('sampai_dengan')
                ->nullable();

            $table->string('petugas_pengganti')
                ->nullable();

            // SDM
            $table->string('hak_hari_cuti')
                ->nullable();

            $table->string('telah_dijalani')
                ->nullable();

            $table->string('izin_potong_cuti')
                ->nullable();

            $table->string('sisa_hari_cuti')
                ->nullable();

            $table->string('sisa_setelah_cuti')
                ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('cuti_approval', function (Blueprint $table) {

            $table->dropColumn([

                'cuti_efektif',
                'sampai_dengan',
                'petugas_pengganti',

                'hak_hari_cuti',
                'telah_dijalani',
                'izin_potong_cuti',
                'sisa_hari_cuti',
                'sisa_setelah_cuti'

            ]);

        });
    }
};