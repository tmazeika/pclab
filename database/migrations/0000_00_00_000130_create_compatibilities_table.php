<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompatibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compatibilities', function(Blueprint $table) {
            $table->integer('component_1_id')->unsigned();
            $table->foreign('component_1_id')->references('id')->on('components')->onDelete('cascade');

            $table->integer('component_2_id')->unsigned();
            $table->foreign('component_2_id')->references('id')->on('components')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compatibilities');
    }
}
