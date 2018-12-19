<?php

use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new \App\User();
        $user->email = 'aajafari87@gmail.com';
        $user->mobile = '09354412285';
        $user->status = 'active';
        $user->code = 0;
        $user->password = bcrypt('ali123456');
        $user->save();
        $user->roles()->attach(1);
        $user->roles()->attach(6);

        $first_name = 'علی';
        $last_name = 'جعفری';

        $profile = new \App\Model\Profiles();
        $profile->user_id = $user->id;
        $profile->first_name = $first_name;
        $profile->last_name = $last_name;
        $profile->avatar = 'http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg';
        $profile->city_id = 117;
        //$profile->hours_of_work = '8-15';
        $profile->address = '';
        $profile->keywords = implode(' - ',[$first_name,$last_name,$first_name.' '.$last_name]); // Add First Name & Last Name For Search
        $profile->location = [41.070611, 28.993083];
        $profile->save();

    }
}
