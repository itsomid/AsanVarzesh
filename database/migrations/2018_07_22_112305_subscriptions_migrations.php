<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubscriptionsMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->integer('program_id');
            $table->integer('plan_id');
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
