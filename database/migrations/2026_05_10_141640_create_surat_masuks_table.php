<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_masuk', function (Blueprint $table) {

            $table->id();

            $table->foreignId('surat_id')
                ->constrained('surat')
                ->onDelete('cascade');

            $table->foreignId('bagian_id')
                ->constrained('bagian')
                ->onDelete('cascade');

            $table->boolean('dibaca')
                ->default(false);

            $table->timestamp('tanggal_dibaca')
                ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};