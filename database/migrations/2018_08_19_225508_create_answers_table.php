<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('ans_id');
            $table->integer('ans_num');
            $table->string('ans_content');
            $table->boolean('ans_correct');
            $table->integer('ques_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('answers', function(Blueprint $table){
            $table->foreign('ques_id')
                ->references('ques_id')->on('questions')
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
        Schema::dropIfExists('answers');
    }
}
