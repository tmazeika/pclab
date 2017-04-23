<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotherboardComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motherboard_components', function (Blueprint $table) {
            $table->increments('id');

            // chassis
            $table->tinyInteger('audio_headers')->unsigned();
            $table->tinyInteger('fan_headers')->unsigned();
            $table->tinyInteger('usb2_headers')->unsigned();
            $table->tinyInteger('usb3_headers')->unsigned();

            $table->integer('form_factor_id')->unsigned();
            $table->foreign('form_factor_id')->references('id')->on('form_factors')->onDelete('restrict');

            // graphics
            $table->boolean('has_displayport_out');
            $table->boolean('has_dvi_out');
            $table->boolean('has_hdmi_out');
            $table->boolean('has_vga_out');
            $table->tinyInteger('pcie3_slots')->unsigned();
            $table->boolean('supports_sli');

            // memory
            $table->smallInteger('dimm_gen')->unsigned();
            $table->smallInteger('dimm_pins')->unsigned();
            $table->tinyInteger('dimm_slots')->unsigned();
            $table->smallInteger('dimm_max_capacity')->unsigned();

            // processor
            $table->tinyInteger('atx12v_pins')->unsigned();

            $table->integer('socket_id')->unsigned();
            $table->foreign('socket_id')->references('id')->on('sockets')->onDelete('restrict');

            // storage
            $table->tinyInteger('sata_slots')->unsigned();

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
