<?php

use Illuminate\Database\Seeder;

class ProfileSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $profile = new \App\Model\Profiles();
        $profile->user_id = 1;
        $profile->first_name = 'علی';
        $profile->last_name = 'اکبری جعفری';
        $profile->avatar = '';
        $profile->photos = '';
        $profile->height = '174';
        $profile->weight = '87.5';
        $profile->blood_type = '+A';
        $profile->diseases = '-';
        $profile->maim = '-';
        $profile->city_id = 1;
        $profile->address = 'فردوس غرب';
        $profile->lat = '37.5697456';
        $profile->lng = '67.5697456';
        $profile->save();
    }
}
