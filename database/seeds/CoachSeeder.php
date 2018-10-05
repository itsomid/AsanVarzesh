<?php

use Illuminate\Database\Seeder;

class CoachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $faker = \Faker\Factory::create('fa_IR');



        for ($i=0; $i < 10; $i++) {
            echo $faker->name, "\n";


            $user = new \App\User();
            $mobile = $faker->mobileNumber;
            $user->mobile = $mobile;
            $user->status = 'active';
            $user->code = 0;
            $user->password = bcrypt($mobile);
            $user->trial = true;
            $user->save();

            $sports = \App\Model\Sport::pluck('id')->toArray();
            $sport_id = $sports[array_rand($sports,1)];

            $user->roles()->attach(3,['sport_id' => $sport_id]);
            $user->coaches()->attach(1,['price' => $faker->randomNumber(5)]);


            $first_name = $faker->firstName();
            $last_name = $faker->lastName();

            $profile = new \App\Model\Profiles();
            $profile->user_id = $user->id;
            $profile->first_name = $first_name;
            $profile->last_name = $last_name;
            $profile->expertise = 'بدن سازی تخصصی';
            $profile->experiences = 'سوابق مربی ';
            $profile->coach_rate = 'professional';
            $profile->birth_date = '1987-09-09';
            $profile->avatar = 'http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg';
            //$profile->height = 190;
            //$profile->weight = 110;
            $profile->photos = [
                'http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg',
                'https://www.tarafdari.com/sites/default/files/contents/user241416/content-note/mhrb-ftmy.jpg'
            ];
            $profile->city_id = 117;
            //$profile->hours_of_work = '8-15';
            $profile->covered_area = 'گیشا - شهرآرا - ستارخان';
            $profile->address = $faker->address;
            $profile->keywords = implode(' - ',[$first_name,$last_name,$first_name.' '.$last_name]); // Add First Name & Last Name For Search
            $profile->location = [41.070611, 28.993083];
            $profile->save();


        }



    }
}
