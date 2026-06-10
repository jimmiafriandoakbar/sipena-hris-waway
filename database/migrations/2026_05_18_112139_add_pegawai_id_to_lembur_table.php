<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lembur', function (Blueprint $table) {

            $table->unsignedBigInteger('pegawai_id')->nullable()->after('surat_id');

        });
    }

    public function down(): void
    {
        Schema::table('lembur', function (Blueprint $table) {

            $table->dropColumn('pegawai_id');

        });
    }
};