<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanhistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporanhist', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_laporan')->nullable();    
            $table->string('status_laporan', 15)->nullable();
            $table->dateTime('tanggal')->nullable();  
            $table->text('keterang')->nullable();
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('laporanhist');
    }
}
