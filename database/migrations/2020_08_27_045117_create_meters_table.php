<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->double('pencatatan_listrik');
            $table->double('pemakaian_listrik')->nullable();
            $table->double('pencatatan_air');
            $table->double('pemakaian_air')->nullable();
            $table->string('bulan_tahun');
            $table->boolean('validasi')->default(0);
            $table->string('gambar1');
            $table->string('gambar2');
            $table->uuid('engineer_id');
            $table->uuid('validator_id')->nullable();
            $table->uuid('apartement_id');
            $table->foreign('engineer_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('validator_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('apartement_id')->references('id')->on('apartements')->onUpdate('cascade');
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
        Schema::dropIfExists('meters');
    }
}
