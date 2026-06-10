<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {

            $table->text('catatan')
                ->nullable();

            $table->unsignedBigInteger('dari_pegawai_id')
                ->nullable();

            $table->boolean('is_disposisi')
                ->default(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {

            $table->dropColumn([

                'catatan',
                'dari_pegawai_id',
                'is_disposisi'

            ]);

        });
    }
};