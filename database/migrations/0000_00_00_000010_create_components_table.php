<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('component_type_id')->unsigned();
            $table->foreign('component_type_id')->references('id')->on('component_types')->onDelete('restrict');

            $table->morphs('child');

            $table->string('asin')->index()->unique();
            $table->boolean('is_available')->default(false);
            $table->string('name');
            $table->integer('price')->unsigned()->default(0);
            $table->smallInteger('watts_usage')->unsigned();
            $table->integer('weight')->unsigned();

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
