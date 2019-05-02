<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CalendarsMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('calendars', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('day_number');
            $table->integer('user_id');
            $table->json('attributes')->nullable();
            $table->integer('used_package_id')->nullable();
            $table->integer('training_id')->nullable();
            $table->integer('meal_id')->nullable();
            $table->dateTime('date')->nullable();
//            $table->dateTime('time_exercise_from')->nullable();
            $table->dateTime('time_from')->nullable();
//            $table->dateTime('time_exercise_to')->nullable();
            $table->dateTime('time_to')->nullable();
            $table->enum('status',['done','delayed','did_not_do','cancelled']);
            $table->enum('type',['training','package']);
            $table->integer('program_id');
            $table->string('comment')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->nullable();
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
        //
    }
}
