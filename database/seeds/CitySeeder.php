<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $city = new \App\Model\Cities();
        $city->title = 'تهران';
        $city->state_id = 1;

        $city = new \App\Model\Cities();
        $city->title = 'اصفهان';
        $city->state_id = 1;

        $city = new \App\Model\Cities();
        $city->title = 'شیراز';
        $city->state_id = 1;

        $city = new \App\Model\Cities();
        $city->title = 'تبریز';
        $city->state_id = 1;

    }
}
