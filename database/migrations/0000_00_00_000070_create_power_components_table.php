<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePowerComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('power_components', function (Blueprint $table) {
            $table->increments('id');

            // cables
            $table->tinyInteger('atx12v_pins')->unsigned();
            $table->tinyInteger('sata_powers')->unsigned();

            // features
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
