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
            $table->json('items');
            $table->integer('food_package_id')->nullable();
            $table->integer('training_id')->nullable();
            $table->integer('meal_id')->nullable(); // ??----------------------
            $table->enum('type',['training','package']);
            $table->integer('program_id');
            $table->text('description');

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
