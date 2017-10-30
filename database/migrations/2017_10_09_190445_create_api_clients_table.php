<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 200);
            $table->timestamps();
        });


        DB::table('api_clients')->insert(
            array(
                array(
                    'id'   => 1,
                    'code' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9',
                )
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_clients');
    }
}
