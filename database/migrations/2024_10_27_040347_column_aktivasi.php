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
        Schema::table('pengawas', function (Blueprint $table) {
            $table->char('status_aktivasi', 1)->default(0);
            $table->string('kode_aktivasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengawas', function (Blueprint $table) {
            $table->dropColumn(['status_aktivasi', 'kode_aktivasi']);
        });
    }
};