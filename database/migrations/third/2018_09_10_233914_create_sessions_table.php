<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('session_id');
            $table->integer('s_id')->unsigned();
            $table->integer('cat_id');
            $table->integer('lev_id');
            $table->bigInteger('session_score');
            $table->string('scoreString')->default(NULL);
            $table->string('questionString')->default(NULL);
            $table->string('answerString')->default(NULL);
            $table->boolean('session_completed')->default('0');
            $table->timestamps();
        });

        Schema::table('sessions', function(Blueprint $table){
            $table->foreign('s_id')
                ->references('s_id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
