<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCISystemInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_system_instances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ci_system_id')->unsigned();
            $table->integer('type');
            $table->integer('component_owner_id')->unsigned();
            $table->integer('api_client_id')->unsigned();
            $table->string('url_build_server', 150);
            $table->string('username_build_server', 150)->nullable();
            $table->string('password_build_server', 150)->nullable();
            $table->integer('url_release_manager');
            $table->string('username_release_manager', 150)->nullable();
            $table->string('password_release_manager', 150)->nullable();

            $table->boolean('verified')->default(0);
            $table->timestamps();
            $table->foreign('ci_system_id')->references('id')->on('ci_systems')->onDelete('cascade');
            $table->foreign('api_client_id')->references('id')->on('api_clients')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ci_system_instances');
    }
}
