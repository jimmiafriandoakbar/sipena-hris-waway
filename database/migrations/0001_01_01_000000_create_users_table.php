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
        Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');

    // 🔥 TAMBAHAN INI
    $table->string('role')->default('pegawai');

    $table->rememberToken();
    $table->timestamps();
});

Schema::create('pegawai', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')->constrained()->onDelete('cascade');

    $table->string('nama');
    $table->string('nip')->unique();
    $table->string('bagian');
    $table->string('jabatan');
    $table->string('no_hp');
    $table->string('email');

    // GAJI
    $table->integer('gaji_pokok')->default(0);
    $table->integer('tunjangan')->default(0);
    $table->integer('bonus')->default(0);
    $table->integer('potongan')->default(0);

    // FILE
    $table->string('ttd')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('pegawai'); // hapus dulu relasi
    Schema::dropIfExists('users');
}
};
