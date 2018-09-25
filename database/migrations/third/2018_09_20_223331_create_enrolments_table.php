<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrolmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolments', function (Blueprint $table) {
            $table->increments('e_id');
            $table->integer('s_id')->unsigned();
            $table->integer('c_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('enrolments',function (Blueprint $table){
            $table->foreign('s_id')
                ->references('s_id')->on('students')
                ->onDelete('cascade');
        });
        Schema::table('enrolments',function (Blueprint $table){
            $table->foreign('c_id')
                ->references('c_id')->on('courses')
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
        Schema::dropIfExists('enrolments');
    }
}
