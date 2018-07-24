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

        $user = new \App\User();
        $user->mobile = '09127115235';
        $user->status = 'active';
        $user->code = 0;
        $user->password = bcrypt('Jafari19870909AliA');
        $user->save();

        $user->roles()->attach(3);
        $user->coachs()->attach(4);

        $profile = new \App\Model\Profiles();
        $profile->user_id = $user->id;
        $profile->first_name = 'مهراب';
        $profile->last_name = 'فاطمی';
        $profile->avatar = '';
        $profile->height = 190;
        $profile->weight = 110;
        $profile->photos = [];
        $profile->city_id = 117;
        $profile->address = 'فاطمی';
        $profile->lat = 37.56;
        $profile->lng = 55.89;
        $profile->save();


        $user = new \App\User();
        $user->mobile = '09127115235';
        $user->status = 'active';
        $user->code = 0;
        $user->password = bcrypt('Jafari19870909AliA');
        $user->save();

        $user->roles()->attach(3,['sport_id' => 1]);


        $profile = new \App\Model\Profiles();
        $profile->user_id = $user->id;
        $profile->first_name = 'مهراب';
        $profile->last_name = 'فاطمی';
        $profile->avatar = '';
        $profile->height = 190;
        $profile->weight = 110;
        $profile->photos = [];
        $profile->city_id = 117;
        $profile->address = 'فاطمی';
        $profile->lat = 37.56;
        $profile->lng = 55.89;
        $profile->keywords = 'مهراب - فاطمی - مهراب فاطمی';
        $profile->save();



    }
}
