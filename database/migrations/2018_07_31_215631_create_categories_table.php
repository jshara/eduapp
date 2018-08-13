<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('cat_id');
            $table->string('cat_name');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('categories',function (Blueprint $table){
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        // DB::table('categories')->insert([
        //     [
        //         'cat_name'=> 'Science',
        //     ],
        //     [
        //         'cat_name'=> 'Physics',
        //     ],
        //     [
        //         'cat_name'=> 'Math',
        //     ]
        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
