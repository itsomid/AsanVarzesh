<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Billing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('price');
            $table->integer('coach_id')->nullable();
            $table->integer('nutrition_id')->nullable();
            $table->integer('corrective_id')->nullable();
            $table->integer('federation_id')->nullable();
            $table->text('description')->nullable();
            $table->enum('status',['not_paid','paid']);
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
