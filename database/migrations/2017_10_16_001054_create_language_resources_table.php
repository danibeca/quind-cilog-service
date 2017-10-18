<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        DB::table('language_resources')->insert(
            array(
                array(
                    'id'   => 1
                ),
                array(
                    'id'   => 2
                ),
                array(
                    'id'   => 3
                )
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_resources');
    }
}
