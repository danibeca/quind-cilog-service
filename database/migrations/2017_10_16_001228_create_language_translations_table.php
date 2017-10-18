<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_translations', function (Blueprint $table) {
            $table->integer('resource_id')->unsigned();
            $table->integer('language_id')->unsigned();
            $table->string('translation',300);
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('language_resources')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

        });

        DB::table('language_translations')->insert(
            array(
                array(
                    'resource_id'   => 1,
                    'language_id'   => 1,
                    'translation'   => 'Code Health'
                ),
                array(
                    'resource_id'   => 1,
                    'language_id'   => 2,
                    'translation'   => 'Salud Código'
                ),
                array(
                    'resource_id'   => 2,
                    'language_id'   => 1,
                    'translation'   => 'Reliability'
                ),
                array(
                    'resource_id'   => 2,
                    'language_id'   => 2,
                    'translation'   => 'Confiabilidad'
                ),
                array(
                    'resource_id'   => 3,
                    'language_id'   => 1,
                    'translation'   => 'Potential Efficiency'
                ),
                array(
                    'resource_id'   => 3,
                    'language_id'   => 2,
                    'translation'   => 'Potencial de Eficiencia'
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
        Schema::dropIfExists('language_translations');
    }
}
