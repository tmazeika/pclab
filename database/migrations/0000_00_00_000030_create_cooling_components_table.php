<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoolingComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooling_components', function (Blueprint $table) {
            $table->increments('id');

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
