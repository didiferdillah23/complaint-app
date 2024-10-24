<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelaporTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelapor', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_admin_tj');
            $table->string('nama', 50);
            $table->string('nipp', 15);
            $table->string('email', 30);
            $table->string('password');
            $table->string('jabatan', 15);
            $table->string('divisi',15);
            $table->string('telepon', 15);
            $table->integer('status');
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
        Schema::dropIfExists('pelapor');
    }
}
