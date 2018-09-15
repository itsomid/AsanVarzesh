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
            $table->json('activities')->nullable();
            //$table->integer('type'); /* Which training */
            $table->float('energy')->nullable();
            $table->integer('time')->nullable(); /* Per Second */
            $table->integer('calendar_id');
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
