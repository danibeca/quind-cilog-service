<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentJobSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_job_series', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',200)->nullable();
            $table->string('type',50)->nullable();
            $table->integer('external_id')->unsigned();
            $table->integer('component_id');
            $table->timestamps();

            //$table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_job_series');
    }
}
