<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_requirements', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('component_id')->unsigned();
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');

            $table->integer('component_type_id')->unsigned();
            $table->foreign('component_type_id')->references('id')->on('component_types')->onDelete('cascade');

            $table->tinyInteger('minimum')->unsigned();
            $table->tinyInteger('maximum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_requirements');
    }
}
