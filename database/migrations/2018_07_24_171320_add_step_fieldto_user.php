<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStepFieldtoUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function ($table) {
            $table->enum('steps',[
                'login_register',
                'profile',
                'choose_federation',
                'choose_sport',
                'choose_coach',
                'physical_info',
                'nutrition_info',
                'waiting_for_confirmation',
                'complete'
                ])->after('permissions');
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
