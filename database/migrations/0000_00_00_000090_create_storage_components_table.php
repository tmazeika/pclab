<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_components', function (Blueprint $table) {
            $table->increments('id');

            // specs
            $table->integer('capacity')->unsigned();
            $table->boolean('is_ssd');

            $table->integer('storage_width_id')->unsigned();
            $table->foreign('storage_width_id')->references('id')->on('storage_widths')->onDelete('restrict');

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
        Schema::dropIfExists('storage_components');
    }
}
