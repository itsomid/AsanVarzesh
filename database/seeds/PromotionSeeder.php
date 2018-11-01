<?php

use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Generate Promotion Code as General
        for($i = 0;$i<=5;$i++) {

            $promotion = new \App\Model\Promotion();
            $promotion->title = 'عنوان کد تخفیف';
            $promotion->code = strtoupper(str_random(10));
            $promotion->percent = 0.25;
            $promotion->max_use_count = 1;
            $promotion->save();

        }

    }
    
}
