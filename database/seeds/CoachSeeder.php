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

        $user->roles()->attach(3,['sport_id' => 1]);
        $user->coachs()->attach(1);

        $profile = new \App\Model\Profiles();
        $profile->user_id = $user->id;
        $profile->first_name = 'مهراب';
        $profile->last_name = 'فاطمی';
        $profile->avatar = '';
        $profile->height = 190;
        $profile->weight = 110;
        $profile->photos = [
            'http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg',
            'https://www.tarafdari.com/sites/default/files/contents/user241416/content-note/mhrb-ftmy.jpg'
        ];
        $profile->city_id = 117;
        $profile->address = 'فاطمی';
        $profile->keywords = implode(' - ',['مهراب','فاطمی','مهراب فاطمی']); // Add First Name & Last Name For Search
        $profile->location = [41.070611, 28.993083];
        $profile->save();

    }
}
