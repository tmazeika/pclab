<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoryComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memory_components', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('component_id')->unsigned()->unique();
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');

            // physical
            $table->tinyInteger('count');
            $table->smallInteger('height');

            // specs
            $table->integer('capacity_each')->unsigned();
            $table->tinyInteger('ddr_gen')->unsigned();
            $table->smallInteger('pins')->unsigned();

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
