<?php

use Illuminate\Database\Seeder;

class Food_Category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $food = new \App\Model\FoodCategory();
        $food->title = 'خشکبار';
        $food->save();

        $food = new \App\Model\FoodCategory();
        $food->title = 'سبزیجات';
        $food->save();

        $food = new \App\Model\FoodCategory();
        $food->title = 'گوشت قرمز';
        $food->save();

        $food = new \App\Model\FoodCategory();
        $food->title = 'گوشت سفید';
        $food->save();

    }
}
