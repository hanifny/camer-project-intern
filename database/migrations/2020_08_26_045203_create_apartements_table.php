<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('unit')->unique();
            $table->integer('lantai');
            $table->uuid('tipe_id');
            $table->foreign('tipe_id')->references('id')->on('types')->onUpdate('cascade');
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
        Schema::dropIfExists('apartements');
    }
}
