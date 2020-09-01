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
            $table->double('pemakaian_listrik');
            $table->double('pencatatan_air');
            $table->double('pemakaian_air');
            $table->date('bulan_tahun');
            $table->string('bukti_gambar');
            $table->boolean('validasi');
            $table->uuid('engineer_id');
            $table->uuid('validator_id');
            $table->uuid('apartement_id');
            $table->foreign('engineer_id')->references('id')->on('users');
            $table->foreign('validator_id')->references('id')->on('users');
            $table->foreign('apartement_id')->references('id')->on('apartements');
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
