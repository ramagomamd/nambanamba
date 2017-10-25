<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSinglesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('music.single.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->integer('category_id')->unsigned();   
            $table->integer('genre_id')->unsigned(); 
            $table->text('description', 500)->nullable();
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
        Schema::dropIfExists(config('music.single.table'));
    }
}
