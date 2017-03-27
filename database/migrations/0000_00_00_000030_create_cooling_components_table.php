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
            $table->integer('component_id')->unsigned()->unique();
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');

            // features
            $table->boolean('is_air');

            // physical
            $table->smallInteger('fan_width')->unsigned();
            $table->smallInteger('height')->unsigned();
            $table->SmallInteger('max_memory_height')->unsigned();
            $table->smallInteger('radiator_length')->unsigned();

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
