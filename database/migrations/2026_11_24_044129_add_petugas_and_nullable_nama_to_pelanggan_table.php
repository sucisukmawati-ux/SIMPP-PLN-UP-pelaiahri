<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->string('petugas', 160)->nullable();
            $table->string('nama', 160)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('pelanggan')->whereNull('nama')->exists()) {
            throw new RuntimeException('Lengkapi nama pelanggan sebelum membatalkan perubahan ini.');
        }

        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn('petugas');
            $table->string('nama', 160)->nullable(false)->change();
        });
    }
};
