<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('music.track.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 190);
            $table->string('slug', 190)->unique()->nullable();
            $table->string('year')->nullable();
            $table->string('number')->nullable();
            $table->text('comment', 500)->nullable();
            $table->string('album')->default('LulaMusic Singles');
            $table->string('bitrate');
            $table->string('duration');
            $table->string('copyright')->default('Copyright @LulaMusic');

            $table->nullableMorphs('trackable');

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
        Schema::dropIfExists(config('music.track.table'));
    }
}
