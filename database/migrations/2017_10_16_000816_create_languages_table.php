<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->string('code',3);
        });

        DB::table('languages')->insert(
            array(
                array(
                    'id'   => 1,
                    'name' => 'English',
                    'code' => 'en',
                ),
                array(
                    'id'   => 2,
                    'name' => 'Español',
                    'code' => 'es',
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
        Schema::dropIfExists('languages');
    }
}
