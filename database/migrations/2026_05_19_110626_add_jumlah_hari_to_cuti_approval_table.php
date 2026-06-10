<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cuti_approval', function (Blueprint $table) {

            $table->string('jumlah_hari')
                ->nullable()
                ->after('sisa_setelah_cuti');

        });
    }

    public function down(): void
    {
        Schema::table('cuti_approval', function (Blueprint $table) {

            $table->dropColumn('jumlah_hari');

        });
    }
};
