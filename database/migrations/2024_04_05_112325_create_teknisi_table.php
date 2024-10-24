<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeknisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teknisi', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->string('nipp', 50);
            $table->string('jabatan', 15);
            $table->string('email', 30);
            $table->string('password');
            $table->string('ttd')->nullable();
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
        Schema::dropIfExists('teknisi');
    }
}
