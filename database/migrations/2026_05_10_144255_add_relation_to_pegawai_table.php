<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {

            $table->foreignId('bagian_id')
                ->nullable()
                ->after('bagian')
                ->constrained('bagian')
                ->nullOnDelete();

            $table->foreignId('jabatan_id')
                ->nullable()
                ->after('jabatan')
                ->constrained('jabatan')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {

            $table->dropForeign(['bagian_id']);

            $table->dropForeign(['jabatan_id']);

            $table->dropColumn([
                'bagian_id',
                'jabatan_id'
            ]);

        });
    }
};