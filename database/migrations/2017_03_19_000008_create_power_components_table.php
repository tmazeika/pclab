<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePowerComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('power_components', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('component_id')->unsigned();
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');

            // cables
            $table->tinyInteger('atx12v_pins')->unsigned();
            $table->tinyInteger('molexes')->unsigned();
            $table->tinyInteger('sata_powers')->unsigned();

            // features
            $table->float('efficiency');
            $table->boolean('is_modular');
            $table->smallInteger('watts_out')->unsigned();

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
        Schema::dropIfExists('power_components');
    }
}
