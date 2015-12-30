<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('slug');

            $table->mediumText('description');

            $table->string('metadescription');

            $table->boolean('is_published');
            $table->boolean('is_completed');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('series');
    }
}
