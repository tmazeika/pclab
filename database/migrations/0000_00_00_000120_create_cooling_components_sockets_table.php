<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoolingComponentsSocketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooling_components_sockets', function(Blueprint $table) {
            $table->integer('cooling_component_id')->unsigned();
            $table->foreign('cooling_component_id')->references('id')->on('cooling_components')->onDelete('cascade');

            $table->integer('socket_id')->unsigned();
            $table->foreign('socket_id')->references('id')->on('sockets')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cooling_components_sockets');
    }
}
