<?php

use Illuminate\Database\Seeder;

class OrphanProgram extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $sports = \App\Model\Sport::all();


        $configuration = [
            [
                'day_number' => 1,
                'items' => [],
                'food_package_id' => null,
                'training_id' => 2,
                'meal_id' => null,
                'type' => 'training',
                'description' => 'lorem ipsum...'
            ],
            [
                'day_number' => 2,
                'items' => [],
                'food_package_id' => null,
                'training_id' => 2,
                'meal_id' => null,
                'type' => 'training',
                'description' => 'lorem ipsum...'
            ],
            [
                'day_number' => 3,
                'items' => [],
                'food_package_id' => null,
                'training_id' => 2,
                'meal_id' => null,
                'type' => 'training',
                'description' => 'lorem ipsum...'
            ],
            [
                'day_number' => 4,
                'items' => [],
                'food_package_id' => null,
                'training_id' => 2,
                'meal_id' => null,
                'type' => 'training',
                'description' => 'lorem ipsum...'
            ],
            [
                'day_number' => 5,
                'items' => [],
                'food_package_id' => null,
                'training_id' => 2,
                'meal_id' => null,
                'type' => 'training',
                'description' => 'lorem ipsum...'
            ],
            [
                'day_number' => 6,
                'items' => [],
                'food_package_id' => null,
                'training_id' => 2,
                'meal_id' => null,
                'type' => 'training',
                'description' => 'lorem ipsum...'
            ],
            [
                'day_number' => 7,
                'items' => [],
                'food_package_id' => null,
                'training_id' => 2,
                'meal_id' => null,
                'type' => 'training',
                'description' => 'lorem ipsum...'
            ]
        ];


        foreach ($sports as $sport) {

            $orphan_program = new \App\Model\Programs();
            $orphan_program->user_id = 0;
            $orphan_program->sport_id = $sport->id;
            $orphan_program->coach_id = 0;
            $orphan_program->nutrition_doctor_id = 0;
            $orphan_program->corrective_doctor_id = 0;
            $orphan_program->subscription_id = 0;
            $orphan_program->start_date = null;
            $orphan_program->status = 'orphan';
            $orphan_program->federation_id = 1;
            $orphan_program->configuration = $configuration;
            $orphan_program->save();

        }

    }
}
