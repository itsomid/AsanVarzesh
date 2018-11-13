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
            //echo $faker->name, "\n";
            $gender = $faker->randomElements(['male', 'female']);

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

            $first_name = $faker->firstName($gender[0]);
            $last_name = $faker->lastName();

            $profile = new \App\Model\Profiles();
            $profile->user_id = $user->id;
            $profile->first_name = $first_name;
            $profile->last_name = $last_name;
            $profile->expertise = 'بدن سازی تخصصی';
            $profile->experiences = 'سوابق مربی ';
            $profile->coach_rate = 'professional';
            $profile->birth_date = '1987-09-09';
            $male_avatar = url('images/fitness_man.jpg');
            $female_avatar = url('images/fitness_woman.jpg');
            $profile->avatar =  $gender[0] == 'male' ? $male_avatar : $female_avatar;
            $profile->gender = $gender[0];
            //$profile->height = 190;
            //$profile->weight = 110;

            $female_photos = [
                url('images/amadegi_jesmani_woman.jpg'),
                url('images/fitness_woman.jpg.jpg')
            ];

            $male_photos = [
                url('images/kesheshi_man.jpg'),
                url('images/fitness_man.jpg')
            ];

            $profile->photos = $gender[0] == 'male' ? $male_photos : $female_photos;
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
