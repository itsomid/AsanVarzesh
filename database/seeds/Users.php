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
        $user->status = 'inactive';
        $user->code = 0;
        $user->password = bcrypt('ali123456');
        $user->save();
        $user->roles()->attach(1);

    }
}
