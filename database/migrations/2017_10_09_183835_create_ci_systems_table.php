<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wrapper_class', 100);
            $table->timestamps();
        });

        DB::table('ci_systems')->insert(
            array(
                array(
                    'id' => 1,
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
        Schema::dropIfExists('ci_systems');
    }
}
