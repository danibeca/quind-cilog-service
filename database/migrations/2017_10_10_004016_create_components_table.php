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
        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->string('key', 100)->nullable();
            $table->string('app_code', 100)->nullable();
            $table->string('classifier_expression', 150)->nullable();
            $table->string('jobs_path', 200)->nullable();
            $table->integer('ci_system_instance_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('ci_system_instance_id')->references('id')->on('ci_system_instances');


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
