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
            $table->unsignedInteger('component_id');
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');
            $table->unsignedTinyInteger('ddr_gen');
            $table->unsignedSmallInteger('frequency');
            $table->unsignedBigInteger('size');
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
