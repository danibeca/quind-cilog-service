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
            $table->integer('tag_id')->unsigned();
            $table->string('key',100)->nullable();
            $table->string('app_code',100)->nullable();
            $table->string('username',100)->nullable();
            $table->string('password',100)->nullable();
            $table->string('api_server_url',250)->nullable();
            $table->string('collection',100)->nullable();
            $table->string('collection_id',100)->nullable();
            $table->integer('ci_system_id')->unsigned()->nullable();
            $table->string('provider_id',100)->nullable();
            $table->timestamps();
            $table->foreign('tag_id')->references('id')->on('hierarchical_tags');
            $table->foreign('ci_system_id')->references('id')->on('ci_systems');

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
