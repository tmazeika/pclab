<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadiatorConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radiator_configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chassis_component_id')->unsigned();
            $table->foreign('chassis_component_id')->references('id')->on('chassis_components')->onDelete('cascade');

            $table->smallInteger('max_fan_width')->unsigned();
            $table->smallInteger('max_length')->unsigned();

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
        Schema::dropIfExists('radiator_configurations');
    }
}
