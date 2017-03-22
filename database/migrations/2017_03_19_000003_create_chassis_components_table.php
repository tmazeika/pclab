<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChassisComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chassis_components', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('component_id')->unsigned();
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');

            // cooling
            $table->smallInteger('max_fan_z')->unsigned();
            $table->smallInteger('max_radiator_x')->unsigned();
            $table->smallInteger('max_radiator_z')->unsigned();

            // graphics
            $table->smallInteger('max_graphics_size_x_blocked')->unsigned();
            $table->smallInteger('max_graphics_size_x_full')->unsigned();

            // motherboard
            $table->tinyInteger('audio_headers')->unsigned();
            $table->tinyInteger('fan_headers')->unsigned();
            $table->tinyInteger('usb2_headers')->unsigned();
            $table->tinyInteger('usb3_headers')->unsigned();

            // power
            $table->boolean('uses_sata_power');

            // storage
            $table->tinyInteger('2p5_bays')->unsigned();
            $table->tinyInteger('3p5_bays')->unsigned();

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
        Schema::dropIfExists('chassis_components');
    }
}
