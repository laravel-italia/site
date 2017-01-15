<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_entries', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('description');
            $table->string('type');

            $table->string('website_url');
            $table->string('github_url');
            $table->string('facebook_url');
            $table->string('twitter_url');

            $table->decimal('longitude', 10, 7);
            $table->decimal('latitude', 10, 7);

            $table->string('region');
            $table->string('city');

            $table->boolean('is_confirmed');
            $table->string('confirmation_token');

            $table->integer('user_id')->unsigned();

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
        Schema::dropIfExists('map_entries');
    }
}
