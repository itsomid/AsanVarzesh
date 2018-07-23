<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentsMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('payments', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id');
            $table->integer('subscription_id')->nullable();
            $table->integer('price');
            $table->string('via')->nullable();
            $table->integer('type'); /* Will Confirm */
            $table->enum('status',['initializing', 'failed', 'pending', 'success']);
            $table->string('reference_id')->nullable();
            $table->integer('promotion_id')->nullable();
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
