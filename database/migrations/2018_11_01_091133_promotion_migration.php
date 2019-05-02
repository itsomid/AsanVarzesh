<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromotionMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('promotions', function (Blueprint $table) {

            $table->increments('id');
            $table->text('title');
            $table->text('code');
            $table->float('percent')->nullable();
            $table->integer('discount_value')->nullable();
            $table->integer('max_use_count')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->integer('coach_id')->nullable();
            $table->integer('sport_id')->nullable();
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
