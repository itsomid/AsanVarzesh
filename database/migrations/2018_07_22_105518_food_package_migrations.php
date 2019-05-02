<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FoodPackageMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('food_package', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->integer('food_id');
            $table->integer('package_id');
            $table->string('unit');
            $table->float('size');
            $table->string('keywords')->nullable(); // For Search

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
