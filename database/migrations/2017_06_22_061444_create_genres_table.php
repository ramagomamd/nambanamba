<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('music.genre.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 190)->unique();
            $table->string('slug', 190)->unique();
            $table->text('description', 500)->nullable();

            $table->nullableMorphs('genreable');

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
        Schema::dropIfExists(config('music.genre.table'));
    }
}