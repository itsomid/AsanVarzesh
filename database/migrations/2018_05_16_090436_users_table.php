<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile')->nullable();
            $table->integer('code')->nullable();
            $table->text('permissions')->nullable();
            $table->enum('status',['active','inactive','disable']);
            $table->string('referal_code')->nullable();
            $table->string('referer_id')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->unique('email');
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
