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


        $training_perday = [
            'day_number' => '0',
            'training' => [
                [
                    'training_id' => '2',
                    'day_description' => 'توضیحات',
                    'attribute' => [
                        "distance" => null,
                        "time" => '30',
                        "speed" => '44',
                        "unit_speed" => "m",
                        "set" => '4',
                        "each_set" => '10',
                        "time_each_set" => '65',
                        'energy' => '350'

                    ]
                ],
                [
                    'training_id' => '3',
                    'day_description' => 'توضیحات',
                    'attribute' => [
                        "distance" => null,
                        "time" => '30',
                        "speed" => '44',
                        "unit_speed" => "m",
                        "set" => '4',
                        "each_set" => '10',
                        "time_each_set" => '65',
                        'energy' => '350'
                    ]
                ]
            ]
        ];

        $training_permonth = [];
        for ($i = 1;$i <= 30 ; $i++) {
            $training_perday['day_number'] = $i;
            array_push($training_permonth,$training_perday);

        }

        $nutrition_perday = [
            'day_number' => 0,
            'meals' => [
                [

                    'meal_id' => '1',
                    //'package_id' => 2,
                    'energy' => '250',
                    'unit' => 'gr',
                    'size' => null,
                    'package' => ['1','3','2']

                ],
                [

                    'meal_id' => '2',
                    //'package_id' => 3,
                    'energy' => '250',
                    'unit' => 'gr',
                    'size' => null,
                    'package' => ['1','3','2']

                ],
                [

                    'meal_id' => '3',
                    //'package_id' => 3,
                    'energy' => '250',
                    'unit' => 'gr',
                    'size' => null,
                    'package' => ['1','3','2']

                ],
                [

                    'meal_id' => '4',
                    //'package_id' => 3,
                    'energy' => '250',
                    'unit' => 'gr',
                    'size' => null,
                    'package' => ['1','3','2']

                ]
            ]
        ];

        $nutrition_permonth = [];
        for ($i = 1;$i <= 30 ; $i++) {
            $nutrition_perday['day_number'] = $i;
            array_push($nutrition_permonth,$nutrition_perday);

        }

        $comp = [
            'trainings' => $training_permonth,
            'nutrition' => $nutrition_permonth
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
            $orphan_program->configuration = $comp;
            $orphan_program->save();

        }

    }
}
