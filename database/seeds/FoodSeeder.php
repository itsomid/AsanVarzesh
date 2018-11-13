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
        $food->food_category_id = 2;
        $food->nutritional_value = [
            [
                'title' => 'چربی',
                'size' => '200',
                'unit' => 'گرم',
            ],
            [
                'title' => 'کلسیم',
                'unit' => 'گرم',
                'size' => '200'
            ],
            [
                'title' => 'پروتئین',
                'unit' => 'گرم',
                'size' => '200'
            ]
        ];
        $food->image = 'https://5.imimg.com/data5/OX/VQ/MY-37032104/fresh-honey-500x500.jpg';
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'نان سنگک';
        $food->description = '';
        $food->details = '';
        $food->energy = 150;
        $food->food_category_id = 2;
        $food->nutritional_value = [
            [
                'title' => 'چربی',
                'size' => '200',
                'unit' => 'گرم',
            ],
            [
                'title' => 'کلسیم',
                'unit' => 'گرم',
                'size' => '200'
            ],
            [
                'title' => 'پروتئین',
                'unit' => 'گرم',
                'size' => '200'
            ]
        ];
        $food->image = 'https://5.imimg.com/data5/OX/VQ/MY-37032104/fresh-honey-500x500.jpg';
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'خامه';
        $food->description = '';
        $food->details = '';
        $food->energy = 100;
        $food->food_category_id = 2;
        $food->nutritional_value = [
            [
                'title' => 'چربی',
                'size' => '200',
                'unit' => 'گرم',
            ],
            [
                'title' => 'کلسیم',
                'unit' => 'گرم',
                'size' => '200'
            ],
            [
                'title' => 'پروتئین',
                'unit' => 'گرم',
                'size' => '200'
            ]
        ];
        $food->image = 'https://5.imimg.com/data5/OX/VQ/MY-37032104/fresh-honey-500x500.jpg';
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'عسل';
        $food->description = '';
        $food->details = '';
        $food->energy = 200;
        $food->food_category_id = 2;
        $food->nutritional_value = [
            [
                'title' => 'چربی',
                'size' => '200',
                'unit' => 'گرم',
            ],
            [
                'title' => 'کلسیم',
                'unit' => 'گرم',
                'size' => '200'
            ],
            [
                'title' => 'پروتئین',
                'unit' => 'گرم',
                'size' => '200'
            ]
        ];
        $food->image = 'https://5.imimg.com/data5/OX/VQ/MY-37032104/fresh-honey-500x500.jpg';
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'کباب برگ';
        $food->description = '';
        $food->details = '';
        $food->energy = 500;
        $food->food_category_id = 3;
        $food->nutritional_value = [
            [
                'title' => 'چربی',
                'size' => '200',
                'unit' => 'گرم',
            ],
            [
                'title' => 'کلسیم',
                'unit' => 'گرم',
                'size' => '200'
            ],
            [
                'title' => 'پروتئین',
                'unit' => 'گرم',
                'size' => '200'
            ]
        ];
        $food->image = 'https://5.imimg.com/data5/OX/VQ/MY-37032104/fresh-honey-500x500.jpg';
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'جوجه کباب';
        $food->description = '';
        $food->details = '';
        $food->energy = 400;
        $food->food_category_id = 3;
        $food->nutritional_value = [
            [
                'title' => 'چربی',
                'size' => '200',
                'unit' => 'گرم',
            ],
            [
                'title' => 'کلسیم',
                'unit' => 'گرم',
                'size' => '200'
            ],
            [
                'title' => 'پروتئین',
                'unit' => 'گرم',
                'size' => '200'
            ]
        ];
        $food->image = 'https://5.imimg.com/data5/OX/VQ/MY-37032104/fresh-honey-500x500.jpg';
        $food->save();

        $food = new \App\Model\Food();
        $food->title = ' سینه مرغ گریل شده';
        $food->description = '';
        $food->details = '';
        $food->energy = 350;
        $food->nutritional_value = [
            [
                'title' => 'چربی',
                'size' => '200',
                'unit' => 'گرم',
            ],
            [
                'title' => 'کلسیم',
                'unit' => 'گرم',
                'size' => '200'
            ],
            [
                'title' => 'پروتئین',
                'unit' => 'گرم',
                'size' => '200'
            ]
        ];
        $food->food_category_id = 1;
        $food->image = 'https://5.imimg.com/data5/OX/VQ/MY-37032104/fresh-honey-500x500.jpg';
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'دلمه';
        $food->description = '';
        $food->details = '';
        $food->energy = 250;
        $food->nutritional_value = [
            [
                'title' => 'چربی',
                'size' => '200',
                'unit' => 'گرم',
            ],
            [
                'title' => 'کلسیم',
                'unit' => 'گرم',
                'size' => '200'
            ],
            [
                'title' => 'پروتئین',
                'unit' => 'گرم',
                'size' => '200'
            ]
        ];
        $food->food_category_id = 3;

        $food->image = 'https://5.imimg.com/data5/OX/VQ/MY-37032104/fresh-honey-500x500.jpg';
        $food->save();

        $food = new \App\Model\Food();
        $food->title = 'نان سبوس دار';
        $food->description = '';
        $food->details = '';
        $food->energy = 150;
        $food->food_category_id = 3;
        $food->image = 'https://5.imimg.com/data5/OX/VQ/MY-37032104/fresh-honey-500x500.jpg';
        $food->save();

    }
}
