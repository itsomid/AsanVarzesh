<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CutomizeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function ($table) {
            $table->string('mobile')->unique()->nullable()->after('password');
            $table->string('mobile_token')->after('mobile')->nullable();
            $table->enum('status',['active','inactive','disable'])->after('mobile_token');
            $table->string('referal_code')->after('status')->nullable();
            $table->string('referer_id')->after('referal_code')->nullable();
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
