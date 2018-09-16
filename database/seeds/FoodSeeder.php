<?php

use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $food = new \App\Model\Food();
        $food->title = 'تخم مرغ';
        $food->description = '';
        $food->details = '';
        $food->energy = 100;
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'نان سنگک';
        $food->description = '';
        $food->details = '';
        $food->energy = 150;
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'خامه';
        $food->description = '';
        $food->details = '';
        $food->energy = 100;
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'عسل';
        $food->description = '';
        $food->details = '';
        $food->energy = 200;
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'کباب برگ';
        $food->description = '';
        $food->details = '';
        $food->energy = 500;
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'جوجه کباب';
        $food->description = '';
        $food->details = '';
        $food->energy = 400;
        $food->save();

        $food = new \App\Model\Food();
        $food->title = ' سینه مرغ گریل شده';
        $food->description = '';
        $food->details = '';
        $food->energy = 350;
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'دلمه';
        $food->description = '';
        $food->details = '';
        $food->energy = 250;
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'نان سبوس دار';
        $food->description = '';
        $food->details = '';
        $food->energy = 150;
        $food->save();

    }
}