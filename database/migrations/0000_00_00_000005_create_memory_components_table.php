<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemoryComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memory_components', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('component_id')->unsigned();
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');

            // physical
            $table->tinyInteger('size_z');

            // specs
            $table->tinyInteger('ddr_gen')->unsigned();
            $table->smallInteger('frequency')->unsigned();
            $table->smallInteger('pins')->unsigned();
            $table->smallInteger('capacity')->unsigned();

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
        Schema::dropIfExists('memory_components');
    }
}
