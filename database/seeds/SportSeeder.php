<?php

use Illuminate\Database\Seeder;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* -------------------------- Add Federation ------------------------------ */

        // Add Federation
        $federation = new \App\Model\Federation();
        $federation->name = 'فدراسیون ورزش های عمومی و سلامتی';
        $federation->type = 'public';
        $federation->image = 'https://via.placeholder.com/650x300';
        $federation->save();

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'تناسب اندام';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = 'https://via.placeholder.com/650x300';
        $sport->save();

//        $steps = [
//            'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4',
//            'steps' => [
//                ' ۱۵ دقیقه گرم کردن ',
//                '۲۰ دقیقه دویدن به صورت کند'
//            ]
//        ];

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'دووی استقامت';
        $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->attribute = [
            "distance" => null,
            "time" => 30,
            "speed" => "44",
            "unit_speed" => "km",
            "set" => 4,
            "each_set" => 10,
            "time_each_set" => 65
        ];
        $training->save();
        $training->accessories()->attach([1,2]);

//        $steps = [
//            [
//                'text' => ' ۱۵ دقیقه گرم کردن ',
//                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
//            ],
//            [
//                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
//                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
//            ]
//        ];

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'وزنه زدن';
        $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->attribute = [
            "distance" => null,
            "time" => 30,
            "speed" => "44",
            "unit_speed" => "km",
            "set" => 4,
            "each_set" => 10,
            "time_each_set" => 65
        ];
        $training->save();
        $training->accessories()->attach([1,2]);

        /* ---------------------------------------------------------------------- */


        /* -------------------------- Add Federation ------------------------------ */

        // Add Federation
        $federation = new \App\Model\Federation();
        $federation->name = 'فدراسیون پرورش اندام و وزنه برداری';
        $federation->image = 'https://via.placeholder.com/650x300';
        $federation->type = 'specialized';

        $federation->save();

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'بادی بیلدینگ';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = 'https://via.placeholder.com/650x300';
        $sport->save();

        /*$steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];*/

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'دووی استقامت';
        $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->attribute = [
            "distance" => null,
            "time" => 30,
            "speed" => "44",
            "unit_speed" => "km",
            "set" => 4,
            "each_set" => 10,
            "time_each_set" => 65
        ];
        $training->save();
        $training->accessories()->attach([1,2]);

        /*$steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];*/

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'وزنه زدن';
        $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->attribute = [
            "distance" => null,
            "time" => 30,
            "speed" => "44",
            "unit_speed" => "km",
            "set" => 4,
            "each_set" => 10,
            "time_each_set" => 65
        ];
        $training->save();
        $training->accessories()->attach([1,2]);

        /* ---------------------------------------------------------------------- */

        /* -------------------------- Add Federation ------------------------------ */

        $federation = new \App\Model\Federation();
        $federation->name = 'فدراسیون ژیمناستیک';
        $federation->type = 'specialized';
        $federation->image = 'https://via.placeholder.com/650x300';
        $federation->save();

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'ورزش ژیمناستیک';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = 'https://via.placeholder.com/650x300';
        $sport->save();

        /*$steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];*/

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'تمرینات کششی';
        $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->attribute = [
            "distance" => null,
            "time" => 30,
            "speed" => "44",
            "unit_speed" => "km",
            "set" => 4,
            "each_set" => 10,
            "time_each_set" => 65
        ];
        $training->save();
        $training->accessories()->attach([1,2]);


        /* ---------------------------------------------------------------------- */

        /* -------------------------- Add Federation ------------------------------ */

        $federation = new \App\Model\Federation();
        $federation->name = 'فدراسیون کشتی';
        $federation->type = 'specialized';
        $federation->image = 'https://via.placeholder.com/650x300';
        $federation->save();

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'کشتی فرنگی';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = 'https://via.placeholder.com/650x300';
        $sport->save();

        /*$steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];*/

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'اشکل گربه';
        $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->attribute = [
            "distance" => null,
            "time" => 30,
            "speed" => "44",
            "unit_speed" => "km",
            "set" => 4,
            "each_set" => 10,
            "time_each_set" => 65
        ];
        $training->save();
        $training->accessories()->attach([1,2]);

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'خورجین تکون';
        $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->attribute = [
            "distance" => null,
            "time" => 30,
            "speed" => "44",
            "unit_speed" => "km",
            "set" => 4,
            "each_set" => 10,
            "time_each_set" => 65
        ];
        $training->save();
        $training->accessories()->attach([1,2]);

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'کشتی آزاد';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = 'https://via.placeholder.com/650x300';
        $sport->save();

        /*$steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];*/

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'زیر یه خم';
        $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->attribute = [
            "distance" => null,
            "time" => 30,
            "speed" => "44",
            "unit_speed" => "km",
            "set" => 4,
            "each_set" => 10,
            "time_each_set" => 65
        ];
        $training->save();
        $training->accessories()->attach([1,2]);

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'زیر بغل';
        $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->attribute = [
            "distance" => null,
            "time" => 30,
            "speed" => "44",
            "unit_speed" => "km",
            "set" => 4,
            "each_set" => 10,
            "time_each_set" => 65
        ];
        $training->save();
        $training->accessories()->attach([1,2]);

        /* ---------------------------------------------------------------------- */




    }
}
