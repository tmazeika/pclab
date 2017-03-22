<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChassisFormFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chassis_form_factors', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('chassis_component_id')->unsigned();
            $table->foreign('chassis_component_id')->references('id')->on('chassis_components');

            $table->string('name');

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
        Schema::dropIfExists('chassis_form_factors');
    }
}
