<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotherboardComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motherboard_components', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('component_id');
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');
            $table->string('socket');
            $table->unsignedSmallInteger('memory_frequency');
            $table->unsignedBigInteger('max_memory_size');
            $table->boolean('has_integrated_graphics');
            $table->string('form_factor');
            $table->boolean('is_sli_allowed');
            $table->boolean('has_hdmi_out');
            $table->boolean('has_displayport_out');
            $table->boolean('has_vga_out');
            $table->boolean('has_dvi_out');
            $table->unsignedTinyInteger('atx12v_pins');
            $table->unsignedTinyInteger('sata_slots');
            $table->unsignedTinyInteger('dimm_slots');
            $table->unsignedTinyInteger('pcie3_slots');
            $table->unsignedTinyInteger('fan_headers');
            $table->unsignedTinyInteger('audio_headers');
            $table->unsignedTinyInteger('usb2_headers');
            $table->unsignedTinyInteger('usb3_headers');
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
        Schema::dropIfExists('motherboard_components');
    }
}
