<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bagian', function (Blueprint $table) {

            $table->id();

            $table->string('kode_bagian')->unique();

            $table->string('nama_bagian')->unique();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bagian');
    }
};