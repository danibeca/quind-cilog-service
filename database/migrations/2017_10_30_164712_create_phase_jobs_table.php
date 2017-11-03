<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhaseJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phase_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('regular_expression', 250);
            $table->integer('process_phase_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('process_phase_id')->references('id')->on('process_phases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phase_jobs');
    }
}
