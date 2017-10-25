<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('music.album.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 190);
            $table->string('slug', 190)->unique()->nullable();
            $table->text('description', 500)->nullable();
            $table->date('release_date')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft'); 
            $table->enum('type', ['album', 'mixtape', 'ep'])->default('album');
            $table->integer('category_id')->unsigned();   
            $table->integer('genre_id')->unsigned(); 
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
        Schema::dropIfExists(config('music.album.table'));
    }
}
