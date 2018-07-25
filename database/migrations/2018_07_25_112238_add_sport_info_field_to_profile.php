<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSportInfoFieldToProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('profiles', function ($table) {

            $table->enum('gender',['male','female'])->after('maim');
            $table->string('birth-date')->nullable()->after('maim');
            $table->integer('daily_activity')->nullable()->after('maim');
            $table->json('selected_days_hours')->nullable()->after('maim');
            $table->string('place_for_sport')->nullable()->after('maim');
            $table->enum('level',['amateur','semi-professional','professional'])->after('maim');
            $table->float('abdominal')->nullable()->after('maim');
            $table->float('arm')->nullable()->after('maim');
            $table->float('wrist')->nullable()->after('maim');
            $table->float('hip')->nullable()->after('maim');
            $table->float('waist')->nullable()->after('maim');
            $table->text('target')->nullable()->after('maim');

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
