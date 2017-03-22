<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChassisComponentsRadiatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chassis_components_radiators', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('chassis_component_id')->unsigned();
            $table->foreign('chassis_component_id')->references('id')->on('chassis_components')->onDelete('cascade');

            $table->boolean('is_max_absolute');
            $table->smallInteger('max_size_x')->unsigned();
            $table->smallInteger('fan_size_xz')->unsigned();

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
        Schema::dropIfExists('chassis_components_radiators');
    }
}
