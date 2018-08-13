<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrainingMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('trainings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('sport_id');
            $table->json('steps');
            $table->enum('difficulty',['Very Easy','Easy','Normal','Hard','Difficult','Very Difficult']);
            $table->text('details');
            $table->json('attribute')->nullable();
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
