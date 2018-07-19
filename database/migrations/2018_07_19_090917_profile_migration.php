<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProfileMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->text('avatar')->nullable();
            $table->json('photos')->nullable();
            $table->float('height');
            $table->float('weight');
            $table->enum('blood_type',['O-','O+','A-','+A','B-','B+','AB-','AB+']);
            $table->json('diseases')->nullable();
            $table->json('maim')->nullable();
            $table->integer('city_id');
            $table->text('address')->nullable();
            $table->decimal('lat')->nullable();
            $table->decimal('lng')->nullable();
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
