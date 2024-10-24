<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetlaporanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detlaporan', function (Blueprint $table) {
            $table->id();
            $table->string('kat_layanan', 30)->nullable();
            $table->string('jenis_layanan', 30)->nullable();
            $table->text('det_layanan')->nullable();
            $table->string('foto')->nullable();
            $table->text('det_pekerjaan')->nullable();
            $table->text('ket_pekerjaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detlaporan');
    }
}
