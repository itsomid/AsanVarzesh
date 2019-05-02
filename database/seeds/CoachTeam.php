<?php

use Illuminate\Database\Seeder;

class CoachTeam extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $coach_role = \App\Model\Role::find(3);
        $coaches = $coach_role->users;

        $nutrition_role = \App\Model\Role::find(4);
        $nutrition_doctor = $nutrition_role->users;
        $nutrition_doctor_arr = [];
        foreach ($nutrition_doctor as $value) {
            array_push($nutrition_doctor_arr,$value->id);
        }


        $corrective_role = \App\Model\Role::find(5);
        $corrective_doctor = $corrective_role->users;
        $corrective_doctor_arr = [];
        foreach ($corrective_doctor as $value) {
            array_push($corrective_doctor_arr,$value->id);
        }

        $coach_team = [];
        $all = [];
        foreach ($coaches as $coach) {

            $n_doctor = $nutrition_doctor_arr[array_rand($nutrition_doctor_arr,1)];
            //unset($nutrition_doctor_arr[$n_doctor]);
            $c_doctor = $corrective_doctor_arr[array_rand($corrective_doctor_arr,1)];
            //unset($corrective_doctor_arr[$c_doctor]);
            $coach->team = ['nutrition_doctor' => $n_doctor,'corrective_doctor' => $c_doctor];
            $coach->save();

        }

    }
}
