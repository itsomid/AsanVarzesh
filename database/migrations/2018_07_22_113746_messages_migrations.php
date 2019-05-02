<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MessagesMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('messages', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('conversation_id');
            $table->integer('user_id');
            $table->text('text')->nullable();
            //$table->enum('status');
            $table->text('attachment')->nullable();
            $table->enum('type',['video','audio','text','picture','file']);
            $table->json('read_status')->nullable();
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
