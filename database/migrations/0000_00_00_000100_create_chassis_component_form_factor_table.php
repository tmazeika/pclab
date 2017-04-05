<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChassisComponentFormFactorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chassis_component_form_factor', function(Blueprint $table) {
            $table->integer('chassis_component_id')->unsigned();
            $table->foreign('chassis_component_id')->references('id')->on('chassis_components')->onDelete('cascade');

            $table->integer('form_factor_id')->unsigned();
            $table->foreign('form_factor_id')->references('id')->on('form_factors')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chassis_component_form_factor');
    }
}