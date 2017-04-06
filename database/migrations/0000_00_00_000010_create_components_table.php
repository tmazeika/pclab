<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('component_type_id')->unsigned();
            $table->foreign('component_type_id')->references('id')->on('component_types')->onDelete('restrict');

            $table->string('asin')->index()->unique();
            $table->string('name');
            $table->smallInteger('watts_usage')->unsigned();
            $table->integer('weight')->unsigned();
            $table->boolean('has_dynamic_compatibilities');

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
        Schema::dropIfExists('components');
    }
}
