<?php

use Illuminate\Database\Seeder;

class RolePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $owner = new \App\Model\Role();
        $owner->name         = 'admin';
        $owner->display_name = 'Admin'; // optional
        $owner->save();

        $owner = new \App\Model\Role();
        $owner->name         = 'user';
        $owner->display_name = 'User'; // optional
        $owner->save();

        $owner = new \App\Model\Role();
        $owner->name         = 'coach';
        $owner->display_name = 'Coach'; // optional
        $owner->save();

        $owner = new \App\Model\Role();
        $owner->name         = 'doctor';
        $owner->display_name = 'Doctor'; // optional
        $owner->save();

        $owner = new \App\Model\Role();
        $owner->name         = 'corrective-doctor';
        $owner->display_name = 'Corrective Doctor'; // optional
        $owner->save();


    }
}
