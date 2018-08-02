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
        $federation->save();

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'تناسب اندام';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->save();

        $steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'دووی استقامت';
        $training->steps = $steps;
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->save();

        $steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'وزنه زدن';
        $training->steps = $steps;
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->save();

        /* ---------------------------------------------------------------------- */


        /* -------------------------- Add Federation ------------------------------ */

        // Add Federation
        $federation = new \App\Model\Federation();
        $federation->name = 'فدراسیون پرورش اندام و وزنه برداری';
        $federation->type = 'specialized';
        $federation->save();

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'بادی بیلدینگ';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->save();

        $steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'دووی استقامت';
        $training->steps = $steps;
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->save();

        $steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'وزنه زدن';
        $training->steps = $steps;
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->save();

        /* ---------------------------------------------------------------------- */

        /* -------------------------- Add Federation ------------------------------ */

        $federation = new \App\Model\Federation();
        $federation->name = 'فدراسیون ژیمناستیک';
        $federation->type = 'specialized';
        $federation->save();

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'ورزش ژیمناستیک';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->save();

        $steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'تمرینات کششی';
        $training->steps = $steps;
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->save();


        /* ---------------------------------------------------------------------- */

        /* -------------------------- Add Federation ------------------------------ */

        $federation = new \App\Model\Federation();
        $federation->name = 'فدراسیون کشتی';
        $federation->type = 'specialized';
        $federation->save();

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'کشتی فرنگی';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->save();

        $steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'اشکل گربه';
        $training->steps = $steps;
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->save();

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'خورجین تکون';
        $training->steps = $steps;
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->save();

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'کشتی آزاد';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->save();

        $steps = [
            [
                'text' => ' ۱۵ دقیقه گرم کردن ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ],
            [
                'text' => ' ۲۰ دقیقه دویدن به صورت کند ',
                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
            ]
        ];

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'زیر یه خم';
        $training->steps = $steps;
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->save();

        // Add Training
        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'زیر بغل';
        $training->steps = $steps;
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->save();

        /* ---------------------------------------------------------------------- */




    }
}
