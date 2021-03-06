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
            $table->string('name', 50);
            $table->boolean('active');
            $table->timestamps();
        });

        DB::table('ci_systems')->insert(
            array(
                array(
                    'id' => 1,
                    'name' => 'VSTS/TFS',
                    'active' => true
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
