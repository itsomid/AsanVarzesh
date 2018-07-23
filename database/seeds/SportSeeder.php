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
        //
        $sport = new \App\Model\Sport();
        $sport->title = 'دوو میدانی';
        $sport->description = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $sport->federation_id = 2;
        $sport->save();


        // Training

        $steps = [
            1 => ' ۱۵ دقیقه گرم کردن ',
            2 => ' ۲۰ دقیقه دویدن به صورت کند ',
            3 => ' ۲۰ دقیقه دقیقه دویدن به صورت تند ',
            4 => ' ۱۰ دقیقه دویدن به صورت آهسته '
        ];

        $training = new \App\Model\Training();
        $training->sport_id = $sport->id;
        $training->title = 'دووی استقامت';
        $training->steps = $steps;
        $training->difficulty = 'Normal';
        $training->details = 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ';
        $training->save();
    }
}
