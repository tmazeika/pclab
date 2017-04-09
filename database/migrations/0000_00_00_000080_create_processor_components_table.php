<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessorComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processor_components', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('component_id')->unsigned()->unique();
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');

            // features
            $table->tinyInteger('cores')->unsigned();
            $table->boolean('has_apu');
            $table->boolean('has_stock_cooler');
            $table->integer('speed')->unsigned();

            $table->integer('socket_id')->unsigned();
            $table->foreign('socket_id')->references('id')->on('sockets')->onDelete('restrict');

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
        Schema::dropIfExists('processor_components');
    }
}
