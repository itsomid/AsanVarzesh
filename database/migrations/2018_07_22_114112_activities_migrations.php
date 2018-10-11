<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivitiesMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('activities', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id');
            $table->float('energy')->nullable();
            $table->integer('calendar_id')->nullable();
            $table->float('time')->nullable();
            $table->float('speed')->nullable();
            $table->string('unit_speed')->nullable();
            $table->float('set')->nullable();
            $table->float('each_set')->nullable();
            $table->float('time_each_set')->nullable();
            $table->float('distance')->nullable();
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
