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
            $table->unsignedInteger('component_id');
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');
            $table->string('form_factor');
            $table->unsignedTinyInteger('fan_wires');
            $table->unsignedTinyInteger('audio_wires');
            $table->unsignedTinyInteger('usb2_wires');
            $table->unsignedTinyInteger('usb3_wires');
            $table->unsignedTinyInteger('min_sata_power_inputs');
            $table->unsignedSmallInteger('radiator_width');
            $table->unsignedSmallInteger('radiator_length');
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
