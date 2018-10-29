<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\FoodPackage;
use App\Model\Meal;
use App\Model\Package;
use App\Model\Programs;
use App\Model\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    public function show($program_id)
    {
        $program = Programs::find($program_id);

        $default_calendar = $program->configuration;

        $training_default = $default_calendar['trainings'];
        $nutrition_default = $default_calendar['nutrition'];

        $all = [];

        $all_trainings = [];
        foreach ($training_default as $item) {
            $item['day_number'];
            $aDay_trainings['day_number'] = $item['day_number'];
            $aDay_trainings['trainings'] = [];
            foreach ($item['training'] as $value) {

                $training = Training::where('id',$value['training_id'])->first()->toArray();
                $training_item = [];

                $training_item['training'] = $training;
                //$training['attribute'] = $value['attribute'];
                $training_item['training']['attribute'] = $value['attribute'];
                array_push($aDay_trainings['trainings'],$training_item);


            }

            array_push($all_trainings,$aDay_trainings);
        }

        $all_packages = [];
        foreach ($nutrition_default as $item) {
            $item['day_number'];
            $aDay_nutritions['day_number'] = $item['day_number'];
            $aDay_nutritions['meals'] = [];

            foreach ($item['meals'] as $value) {
                $packages = [];
                $meal = Meal::find($value['meal_id']);
                $foods = Package::with('foods')->whereIn('id',$value['familiar'])->first();
                $nutrition_item = [];
                $nutrition_item['meal'] = $meal;
                $nutrition_item['foods'] = $foods->foods;

                array_push($aDay_nutritions['meals'],$nutrition_item);

            }

            array_push($all_packages,$aDay_nutritions);

        }




        $all['trainings'] = $all_trainings;
        $all['nutrition'] = $all_packages;

        return $all;

    }

    public function update($program_id,Request $request)
    {
        $training = [
            [
                'day_number' => 0,
                'training' => [
                    [
                        'training_id' => 2,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ],
                    [
                        'training_id' => 3,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ]
                ]
            ],
            [
                'day_number' => 1,
                'training' => [
                    [
                        'training_id' => 2,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ],
                    [
                        'training_id' => 3,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ]
                ]
            ],
            [
                'day_number' => 2,
                'training' => [
                    [
                        'training_id' => 2,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ],
                    [
                        'training_id' => 3,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ]
                ]
            ],
            [
                'day_number' => 3,
                'training' => [
                    [
                        'training_id' => 2,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ],
                    [
                        'training_id' => 3,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ]
                ]
            ],
            [
                'day_number' => 4,
                'training' => [
                    [
                        'training_id' => 2,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ],
                    [
                        'training_id' => 3,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ]
                ]
            ],
            [
                'day_number' => 5,
                'training' => [
                    [
                        'training_id' => 2,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ],
                    [
                        'training_id' => 3,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ]
                ]
            ],
            [
                'day_number' => 6,
                'training' => [
                    [
                        'training_id' => 2,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ],
                    [
                        'training_id' => 3,
                        'attribute' => [
                            'distance' => null,
                            'time' => 30,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => 65
                        ]
                    ]
                ]
            ],


        ];
        $nutrition_perday = [
            'day_number' => 0,
            'meals' => [
                [

                    'meal_id' => 1,
                    'food_package_id' => 2,
                    'energy' => 250,
                    'unit' => 'gr',
                    'size' => null,
                    'time' => '08:00'

                ],
                [

                    'meal_id' => 2,
                    'food_package_id' => 2,
                    'energy' => 250,
                    'unit' => 'gr',
                    'size' => null,
                    'time' => '11:00'

                ],
                [

                    'meal_id' => 3,
                    'food_package_id' => 2,
                    'energy' => 250,
                    'unit' => 'gr',
                    'size' => null,
                    'time' => '13:00'

                ],
                [

                    'meal_id' => 4,
                    'food_package_id' => 2,
                    'energy' => 250,
                    'unit' => 'gr',
                    'size' => null,
                    'time' => '20:00'

                ]
            ]
        ];

        $perweek = [];
        for ($i = 0;$i <= 6 ; $i++) {
            $nutrition_perday['day_number'] = $i;
            array_push($perweek,$nutrition_perday);

        }

        $comp = [
            'trainings' => $training,
            'nutrition' => $perweek
        ];

        $data = $request->all();
        $program = Programs::find($program_id);
        $program->status = $data['status'];
        $program->configuration = $data['configuration'];
        $program->description = $data['description'];
        $program->save();

        // TODO: Generate Calendar

        if ($program->status == 'accept')
        {
            $status = 'برنامه تائید شد';

        }
        else
        {
            $status = "برنامه از طرف شما رد شد";
        }


        return response()->json(['message' => $status],200);

    }
}
