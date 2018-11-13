<?php

use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $meal = new \App\Model\Meal();
        $meal->title = 'صبحانه';
        $meal->time_from = '09:30';
        $meal->time_to = '10:30';
        $meal->save();

        $meal = new \App\Model\Meal();
        $meal->title = 'ناهار';
        $meal->time_from = '12:30';
        $meal->time_to = '13:30';
        $meal->save();

        $meal = new \App\Model\Meal();
        $meal->title = 'شام';
        $meal->time_from = '20:30';
        $meal->time_to = '21:30';
        $meal->save();
    }
}
