<?php

use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $countries = \App\Model\Countries::create(
            ['summary' => 'IRI','title' => 'ایران']
        );

    }
}
