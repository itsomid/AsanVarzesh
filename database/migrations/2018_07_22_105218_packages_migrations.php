<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PackagesMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('meal_id');
            $table->string('unit')->nullable();
            $table->float('size')->nullable();
            $table->integer('creator_id')->nullable(); // Who Created this Package
            $table->text('description')->nullable();
            $table->text('how_to_cooking')->nullable();
            $table->text('image')->nullable();
            $table->json('nutritional_value')->nullable();
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
