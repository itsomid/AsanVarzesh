<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProgramsMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('programs', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id');
            $table->integer('sport_id');
            $table->integer('coach_id');
            $table->integer('doctor_id')->nullable();
            $table->integer('currective_doctor_id')->nullable();
            $table->integer('subscription_id')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->enum('status',['active','pending','inactive']);
            $table->text('configuration')->nullable();
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
