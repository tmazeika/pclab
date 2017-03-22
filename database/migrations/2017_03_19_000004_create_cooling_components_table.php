<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoolingComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooling_components', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('component_id')->unsigned();
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');

            // features
            $table->boolean('is_air');

            // physical
            $table->smallInteger('fan_xy')->unsigned();
            $table->smallInteger('fan_z')->unsigned();
            $table->smallInteger('radiator_x')->unsigned()->nullable();
            $table->smallInteger('radiator_z')->unsigned()->nullable();
            $table->tinyInteger('max_memory_z')->unsigned()->nullable();

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
        Schema::dropIfExists('cooling_components');
    }
}
