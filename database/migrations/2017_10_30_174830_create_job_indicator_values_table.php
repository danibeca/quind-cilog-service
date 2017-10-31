<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobIndicatorValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_indicator_values', function (Blueprint $table) {
            $table->integer('component_id')->unsigned();
            $table->integer('phase_id')->unsigned();
            $table->integer('total_jobs');
            $table->integer('existing_jobs');
            $table->double('value');
            $table->timestamps();

            $table->index(['component_id','phase_id']);
            $table->foreign('component_id', 'fk_indicator_component')->references('id')->on('components')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_indicator_values');
    }
}
