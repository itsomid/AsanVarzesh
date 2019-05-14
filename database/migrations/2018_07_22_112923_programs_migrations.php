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
            $table->integer('nutrition_doctor_id')->nullable();
            $table->integer('corrective_doctor_id')->nullable();
            $table->integer('subscription_id')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->enum('status',['active', 'pending','awaiting_payment', 'inactive', 'orphan', 'accept', 'reject','cancel']);
            $table->boolean('trainings_confirmation')->default(false);
            $table->boolean('meals_confirmation')->default(false);
            $table->integer('federation_id');
            $table->json('configuration')->nullable();
            $table->text('text')->nullable();


            // Sport Info
            $table->decimal('weight')->nullable();
            $table->float('abdominal')->nullable();
            $table->float('arm')->nullable();
            $table->float('wrist')->nullable();
            $table->float('hip')->nullable();
            $table->float('waist')->nullable();
            $table->string('place_for_sport')->nullable();
            $table->json('time_of_exercises')->nullable(); // Days of the week
            $table->text('level')->nullable();
            $table->text('target')->nullable();
            $table->text('sport_habits')->nullable();

            $table->text('nutrition_desc')->nullable();
            $table->text('sport_desc')->nullable();

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
