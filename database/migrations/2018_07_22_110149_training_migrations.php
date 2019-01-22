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
            //$table->text('image')->nullable();
            $table->text('attachment')->nullable();
            $table->text('image')->nullable();
            $table->text('audio_short')->nullable();
            $table->text('audio_full')->nullable();
            $table->enum('difficulty',['Very Easy','Easy','Normal','Hard','Difficult','Very Difficult']);
            $table->text('details')->nullable();;
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
