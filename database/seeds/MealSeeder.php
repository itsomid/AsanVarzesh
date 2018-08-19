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
        $meal->save();

        $meal = new \App\Model\Meal();
        $meal->title = 'ناهار';
        $meal->save();

        $meal = new \App\Model\Meal();
        $meal->title = 'شام';
        $meal->save();

        $meal = new \App\Model\Meal();
        $meal->title = 'میان وعده';
        $meal->save();
    }
}
