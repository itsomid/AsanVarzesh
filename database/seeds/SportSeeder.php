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
        $federation->name = 'فدراسیون همگانی';
        $federation->type = 'public';
        $federation->image = 'https://via.placeholder.com/650x300';
        $federation->save();

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'آمادگی جسمانی و ایروبیک';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/amadegi_jesmani.jpg');
        $sport->enable = true;
        $sport->save();


        // Add Training
        for($i = 1;$i<16;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره ' . $i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => '30',
                "speed" => "44",
                "unit_speed" => "m",
                "set" => '4',
                "each_set" => '10',
                "time_each_set" => '65',
                'energy' => '350'
            ];
            $training->save();
            $training->accessories()->attach([1, 2]);
        }

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'پیلاتس';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/amadegi_jesmani.jpg');
        $sport->enable = false;
        $sport->save();


        // Add Training
        for($i = 1;$i<16;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره ' . $i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => '30',
                "speed" => "44",
                "unit_speed" => "m",
                "set" => '4',
                "each_set" => '10',
                "time_each_set" => '65',
                'energy' => '350'
            ];
            $training->save();
            $training->accessories()->attach([1, 2]);
        }


        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = ' یوگا';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/kesheshi.jpg');
        $sport->enable = false;
        $sport->save();


        // Add Training
        for($i = 1;$i<16;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره ' . $i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => '30',
                "speed" => "44",
                "unit_speed" => "m",
                "set" => '4',
                "each_set" => '10',
                "time_each_set" => '65',
                'energy' => '350'
            ];
            $training->save();
            $training->accessories()->attach([1, 2]);
        }


        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = ' بازی ها و ورزش کودکان';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/kesheshi.jpg');
        $sport->enable = false;
        $sport->save();


        // Add Training
        for($i = 1;$i<5;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره ' . $i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => '30',
                "speed" => "44",
                "unit_speed" => "m",
                "set" => '4',
                "each_set" => '10',
                "time_each_set" => '65',
                'energy' => '350'
            ];
            $training->save();
            $training->accessories()->attach([1, 2]);
        }


        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = ' پیاده روی';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/kesheshi.jpg');
        $sport->enable = false;
        $sport->save();


        // Add Training
        for($i = 1;$i<5;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره ' . $i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => '30',
                "speed" => "44",
                "unit_speed" => "m",
                "set" => '4',
                "each_set" => '10',
                "time_each_set" => '65',
                'energy' => '350'
            ];
            $training->save();
            $training->accessories()->attach([1, 2]);
        }

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'ورزش بزرگسالان';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/kesheshi.jpg');
        $sport->enable = true;
        $sport->save();


        // Add Training
        for($i = 1;$i<5;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره ' . $i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => '30',
                "speed" => "44",
                "unit_speed" => "m",
                "set" => '4',
                "each_set" => '10',
                "time_each_set" => '65',
                'energy' => '350'
            ];
            $training->save();
            $training->accessories()->attach([1, 2]);
        }

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'ورزش روزانه';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/kesheshi.jpg');
        $sport->enable = true;
        $sport->save();


        // Add Training
        for($i = 1;$i<5;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره ' . $i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => '30',
                "speed" => "44",
                "unit_speed" => "m",
                "set" => '4',
                "each_set" => '10',
                "time_each_set" => '65',
                'energy' => '350'
            ];
            $training->save();
            $training->accessories()->attach([1, 2]);
        }

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'TRX';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/kesheshi.jpg');
        $sport->enable = true;
        $sport->save();


        // Add Training
        for($i = 1;$i<5;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره ' . $i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => '30',
                "speed" => "44",
                "unit_speed" => "m",
                "set" => '4',
                "each_set" => '10',
                "time_each_set" => '65',
                'energy' => '350'
            ];
            $training->save();
            $training->accessories()->attach([1, 2]);
        }

        /* ---------------------------------------------------------------------- */



        /* -------------------------- Add Federation ------------------------------ */

        // Add Federation
        $federation = new \App\Model\Federation();
        $federation->name = 'فدراسیون بدنسازی و پرورش اندام';
        $federation->image = url('images/fitness_federation.jpg');
        $federation->type = 'specialized';
        $federation->save();

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'بادی کلاسیک';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/bodyclassic.jpg');
        $sport->enable = true;
        $sport->save();



        // Add Training
        for($i = 1;$i<16;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره '.$i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => "30",
                "speed" => "44",
                "unit_speed" => "m",
                "set" => "4",
                "each_set" =>"10",
                "time_each_set" => "65",
                'energy' => "350"
            ];
            $training->save();
            $training->accessories()->attach([1,2]);
        }


        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'فیتنس';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/fitness.jpg');
        $sport->enable = true;
        $sport->save();

        // Add Training
        for($i = 1;$i<16;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره '.$i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => "30",
                "speed" => "44",
                "unit_speed" => "m",
                "set" => "4",
                "each_set" =>"10",
                "time_each_set" => "65",
                'energy' => "350"
            ];
            $training->save();
            $training->accessories()->attach([1,2]);
        }

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'بادی بیلدینگ';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/fitness.jpg');
        $sport->enable = true;
        $sport->save();

        // Add Training
        for($i = 1;$i<6;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره '.$i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => "30",
                "speed" => "44",
                "unit_speed" => "m",
                "set" => "4",
                "each_set" =>"10",
                "time_each_set" => "65",
                'energy' => "350"
            ];
            $training->save();
            $training->accessories()->attach([1,2]);
        }

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'پاور لیفتینگ';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/fitness.jpg');
        $sport->enable = true;
        $sport->save();

        // Add Training
        for($i = 1;$i<6;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره '.$i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => "30",
                "speed" => "44",
                "unit_speed" => "m",
                "set" => "4",
                "each_set" =>"10",
                "time_each_set" => "65",
                'energy' => "350"
            ];
            $training->save();
            $training->accessories()->attach([1,2]);
        }

        // Add Sport
        $sport = new \App\Model\Sport();
        $sport->title = 'تمرین با وزن بدن';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = $federation->id;
        $sport->image = url('images/fitness.jpg');
        $sport->enable = true;
        $sport->save();

        // Add Training
        for($i = 1;$i<6;$i++) {
            $training = new \App\Model\Training();
            $training->sport_id = $sport->id;
            $training->title = 'تمرین شماره '.$i;
            $training->attachment = 'http://techslides.com/demos/sample-videos/small.mp4';
            $training->difficulty = 'Normal';
            $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
            $training->attribute = [
                "distance" => null,
                "time" => "30",
                "speed" => "44",
                "unit_speed" => "m",
                "set" => "4",
                "each_set" =>"10",
                "time_each_set" => "65",
                'energy' => "350"
            ];
            $training->save();
            $training->accessories()->attach([1,2]);
        }



        /* ---------------------------------------------------------------------- */




    }
}
