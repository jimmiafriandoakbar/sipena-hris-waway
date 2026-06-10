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
    Schema::table('payrolls', function (Blueprint $table) {
        $table->decimal('koperasi_pinjaman', 15, 2)
            ->default(0)
            ->after('koperasi');
    });
}

public function down(): void
{
    Schema::table('payrolls', function (Blueprint $table) {
        $table->dropColumn('koperasi_pinjaman');
    });
}
};
