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
            $table->integer('player_id')->unsigned();
            $table->integer('cat_id');
            $table->integer('lev_id');
            $table->bigInteger('session_score');
            $table->boolean('session_completed')->default('0');
            $table->timestamps();
        });

        Schema::table('sessions', function(Blueprint $table){
            $table->foreign('player_id')
                ->references('player_id')->on('players');
        });
        // Schema::table('sessions', function(Blueprint $table){
        //     $table->foreign('cat_id')
        //         ->references('cat_id')->on('categories');
        // });
        // Schema::table('sessions', function(Blueprint $table){
        //     $table->foreign('lev_id')
        //         ->references('lev_id')->on('levels');
        // });
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
