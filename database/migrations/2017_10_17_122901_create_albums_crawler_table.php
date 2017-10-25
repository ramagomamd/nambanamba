<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsCrawlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums_crawler', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('link')->unique();
            $table->string('site_name');
            $table->string('zip')->nullable();
            $table->string('cover')->nullable();
            $table->string('category')->nullable();
            $table->string('genre')->nullable();
            $table->boolean('crawled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums_crawler');
    }
}
