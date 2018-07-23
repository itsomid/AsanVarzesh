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
            $table->integer('meal_id');
            $table->enum('type',['active','inactive','pending']);
            $table->integer('program_id');

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
