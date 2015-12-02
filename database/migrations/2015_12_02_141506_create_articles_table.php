<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('slug');

            $table->string('digest');
            $table->mediumText('body');

            $table->string('metadescription');

            $table->boolean('is_published');
            $table->dateTime('published_at')->nullable();

            $table->integer('user_id')->unsigned();

            $table->timestamps();
        });

        Schema::create('article_category', function(Blueprint $table){
            $table->increments('id');

            $table->integer('article_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
        Schema::drop('article_category');
    }
}
