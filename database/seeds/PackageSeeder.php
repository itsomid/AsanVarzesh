<?php

use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* Breakfast */
        $package = new \App\Model\Package();
        $package->title = 'پکیج صبحانه';
        $package->meal_id = 1;
        $package->unit = 'gr';
        $package->size = 600;
        $package->nutritional_value = [
            [
                'چربی',
                '200 گرم'
            ],
            [
                'کلسیم',
                '200 گرم'
            ],
            [
                'پروتئین',
                '200 گرم'
            ]
        ];
        $package->save();

        $package->foods()->attach('1',['title' => 'صبحانه','unit' => 'gr','size' => 600]);
        $package->foods()->attach('2',['title' => 'صبحانه','unit' => 'gr','size' => 600]);

        /* Lunch */
        $package = new \App\Model\Package();
        $package->title = 'پکیج ناهار';
        $package->meal_id = 1;
        $package->unit = 'gr';
        $package->size = 800;
        $package->nutritional_value = [
            [
                'چربی',
                '200 گرم'
            ],
            [
                'کلسیم',
                '200 گرم'
            ],
            [
                'پروتئین',
                '200 گرم'
            ]
        ];
        $package->save();

        $package->foods()->attach('5',['title' => 'ناهار','unit' => 'gr','size' => 600]);
        $package->foods()->attach('2',['title' => 'ناهار','unit' => 'gr','size' => 600]);


        $package = new \App\Model\Package();
        $package->title = 'پکیج ناهار';
        $package->meal_id = 1;
        $package->unit = 'gr';
        $package->size = 800;
        $package->nutritional_value = [
            [
                'چربی',
                '200 گرم'
            ],
            [
                'کلسیم',
                '200 گرم'
            ],
            [
                'پروتئین',
                '200 گرم'
            ]
        ];
        $package->save();

        $package->foods()->attach('7',['title' => 'ناهار','unit' => 'gr','size' => 600]);
        $package->foods()->attach('9',['title' => 'ناهار','unit' => 'gr','size' => 600]);


        /* Dinner */
        $package = new \App\Model\Package();
        $package->title = 'پکیج شام';
        $package->meal_id = 1;
        $package->unit = 'gr';
        $package->size = 800;
        $package->nutritional_value = [
            [
                'چربی',
                '200 گرم'
            ],
            [
                'کلسیم',
                '200 گرم'
            ],
            [
                'پروتئین',
                '200 گرم'
            ]
        ];
        $package->save();

        $package->foods()->attach('6',['title' => 'ناهار','unit' => 'gr','size' => 600]);
        $package->foods()->attach('2',['title' => 'ناهار','unit' => 'gr','size' => 600]);


        $package = new \App\Model\Package();
        $package->title = 'پکیج شام';
        $package->meal_id = 1;
        $package->unit = 'gr';
        $package->size = 800;
        $package->nutritional_value = [
            [
                'چربی',
                '200 گرم'
            ],
            [
                'کلسیم',
                '200 گرم'
            ],
            [
                'پروتئین',
                '200 گرم'
            ]
        ];
        $package->save();

        $package->foods()->attach('6',['title' => 'ناهار','unit' => 'gr','size' => 600]);
        $package->foods()->attach('9',['title' => 'ناهار','unit' => 'gr','size' => 600]);

    }
}
