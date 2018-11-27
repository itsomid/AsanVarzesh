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
            $table->string('expertise')->nullable();
            $table->string('coach_rate')->nullable();
            $table->text('text')->nullable();
            $table->text('avatar')->nullable();
            $table->json('photos')->nullable();
            $table->float('height')->nullable();
            $table->enum('blood_type',['O-','O+','A-','+A','B-','B+','AB-','AB+']);
            $table->text('diseases')->nullable();
            $table->json('maim')->nullable();
            $table->integer('city_id');
            $table->text('address')->nullable();
            $table->text('keywords')->nullable();
            $table->text('nutrition_info')->nullable();
            $table->string('birth_date')->nullable();
            $table->text('national_code')->nullable();
            $table->string('education'/*,['diploma','Associate_Degree','Bachelor','MA']*/)->nullable();
            $table->string('education_title')->nullable();
            $table->text('experiences')->nullable();
            $table->string('military_services')->nullable();
            $table->text('budget')->nullable();
            $table->text('appetite')->nullable();
            $table->enum('gender',['male','female']);
            $table->timestamps();


        });

        DB::statement('ALTER TABLE profiles ADD location POINT' );


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('profiles');
    }
}
