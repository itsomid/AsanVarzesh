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
            $table->integer('user_id')->nullable();
            $table->integer('program_id')->nullable();
            $table->integer('coach_id')->nullable();
            $table->integer('nutrition_doctor_id')->nullable();
            $table->integer('corrective_doctor_id')->nullable();
            $table->integer('subscription_id')->nullable();
            $table->integer('price')->nullable();
            $table->enum('type',['credit','debit']);
            $table->string('via')->nullable();
            $table->enum('status',['failed', 'pending', 'success','return']);
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
