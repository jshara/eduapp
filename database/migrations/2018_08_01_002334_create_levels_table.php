<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->increments('lev_id');
            $table->integer('lev_num');
            $table->string('lev_location');
            $table->integer('numOfQues');
            $table->integer('cat_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('levels', function(Blueprint $table){
            $table->foreign("cat_id")
                ->references('cat_id')->on('categories')
                ->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('levels');
    }
}
