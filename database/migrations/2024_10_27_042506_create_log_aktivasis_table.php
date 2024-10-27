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
        Schema::create('log_aktivasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('relatable_id');
            $table->string('relatable_type');
            $table->char('status_aktivasi', 1)->default(0);
            $table->string('kode_aktivasi')->nullable();
            $table->enum('persetujuan_pengawas', ['pengajuan', 'disetujui', 'ditolak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivasis');
    }
};
