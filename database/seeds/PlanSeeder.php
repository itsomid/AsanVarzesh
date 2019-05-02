<?php

use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $plan = new \App\Model\Plan();
        $plan->title = 'تناسب اندام - لاغری - یک ماهه';
        $plan->price = 25000;
        $plan->sport_id = 1;
        $plan->save();

        $plan = new \App\Model\Plan();
        $plan->title = 'بادی بیلدینگ - یک ماهه';
        $plan->price = 25000;
        $plan->sport_id = 2;
        $plan->save();

        $plan = new \App\Model\Plan();
        $plan->title = 'کشتی فرنگی - یک ماهه';
        $plan->price = 25000;
        $plan->sport_id = 4;
        $plan->save();

        $plan = new \App\Model\Plan();
        $plan->title = 'کشتی آزاد - یک ماهه';
        $plan->price = 25000;
        $plan->sport_id = 4;
        $plan->save();

    }
}
