<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConversationsMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('conversations', function (Blueprint $table) {

            $table->increments('id');
            $table->text('title');
            $table->integer('program_id')->nullable();
            $table->integer('started_by')->nullable();
            $table->enum('type',['private','group']);
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
