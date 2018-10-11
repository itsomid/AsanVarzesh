<?php

use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_role = \App\Model\Role::find(2);
        $users = $user_role->users;
        foreach ($users as $user) {

            $activity = new \App\Model\Activity();
            $activity->user_id = $user->id;
            $activity->energy = 300;
            $activity->calendar_id = 17;
            $activity->time	 = 3520;
            $activity->speed = 5;
            $activity->unit_speed = 'km';
            $activity->set = 4;
            $activity->time_each_set = 95;
            $activity->distance = 2000; /* By Meter */
            $activity->save();

            $activity = new \App\Model\Activity();
            $activity->user_id = $user->id;
            $activity->energy = 300;
            $activity->calendar_id = 17;
            $activity->time	 = 3520; /* By Second */
            $activity->speed = 5; /* By Meter */
            $activity->unit_speed = 'km';
            $activity->set = 4;
            $activity->time_each_set = 95;
            $activity->distance = 2000; /* By Meter */
            $activity->save();

        }


    }
}
