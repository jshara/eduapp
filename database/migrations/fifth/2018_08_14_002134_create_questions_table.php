<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('ques_id');
            $table->integer('ques_num');
            $table->longText('ques_content');
            $table->boolean('ques_hide')->default('0');
            $table->integer('lev_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('questions', function(Blueprint $table){
            $table->foreign('lev_id')
                ->references('lev_id')->on('levels')
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
        Schema::dropIfExists('questions');
    }
}
