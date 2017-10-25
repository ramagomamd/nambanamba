<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('music.artist.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 190)->unique();
            $table->string('slug', 190)->unique()->nullable();
            $table->text('bio', 500)->nullable();
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
        Schema::dropIfExists(config('music.artist.table'));
    }
}
