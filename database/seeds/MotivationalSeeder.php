<?php

use Illuminate\Database\Seeder;

class MotivationalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('fa_IR');

        for ($i = 0;$i <= 20;$i++)
        {

            $motivate = new \App\Model\Motivational();
            $motivate->phrase = $faker->sentence($nbWords = 6, $variableNbWords = true);
            $motivate->save();

        }
    }
}
