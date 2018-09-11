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
            $table->text('text');
            //$table->enum('status');
            $table->text('attachment');
            $table->text('type',['video','audio','text','picture','file']);
            $table->json('read_status');
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
