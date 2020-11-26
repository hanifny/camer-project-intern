<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeterRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meter_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['el', 'wt']);
            $table->double('meter_start')->nullable();
            $table->double('meter_end');
            $table->string('month_year');
            $table->string('image');
            $table->boolean('validation')->default(0);
            $table->uuid('engineer_id');
            $table->uuid('validator_id')->nullable();
            $table->uuid('unit_id');
            $table->foreign('engineer_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('validator_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade');
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
        Schema::dropIfExists('meter_records');
    }
}
