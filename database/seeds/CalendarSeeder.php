<?php

use Illuminate\Database\Seeder;

class CalendarSeeder extends Seeder
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

        foreach ($users as $user)
        {

            /* Create A Program */
            $date = '2018-09-09';
            $program = new \App\Model\Programs();
            $program->user_id = $user->id;
            $program->sport_id = 1;
            $program->coach_id = 1;
            $program->nutrition_doctor_id = 13;
            $program->corrective_doctor_id = 16;
            $program->start_date = $date;
            $program->status = 'active';
            $program->federation_id = 1;
            $program->configuration = array();
            $program->weight = 90;
            $program->abdominal = 1;
            $program->arm = 1;
            $program->wrist = 1;
            $program->hip = 1;
            $program->waist = 1;
            $program->place_for_sport = 'خانه';
            $program->time_of_exercises = array();
            $program->level = 'amateur';
            $program->target = 'تناسب اندام';
            $program->description = '';
            $program->save();

            // Add Subscription
            $start_date = explode('-',$date);
            $from = \Carbon\Carbon::create($start_date[0],$start_date[1],$start_date[2])->format('Y-m-d H:i:s');
            $to = \Carbon\Carbon::create($start_date[0],$start_date[1],$start_date[2])->addDay('30');

            $subscription = new \App\Model\Subscription();
            $subscription->user_id = $user->id;
            $subscription->from = $from;
            $subscription->to = $to;
            $subscription->program_id = $program->id;
            $subscription->coach_sport_id = 1;
            $subscription->save();

            /* Create Calendar User */
            $this->generateCalendar($user->id,$program->id,$date);

        }

    }

    public function generateCalendar($user_id,$program_id,$date) {

        $trainings = \App\Model\Training::pluck('id')->toArray();
        $packages = \App\Model\Package::pluck('id')->toArray();

        $start_date = explode('-',$date);
        $date = \Carbon\Carbon::create($start_date[0],$start_date[1],$start_date[2],00,00,00);

        for ($i = 1; $i <= 30; $i++) {

            // Add A Training




            $carbon_date_hour1 = \Carbon\Carbon::parse($date);
            $from_hour = $carbon_date_hour1->addHours(8);
            $carbon_date_hour2 = \Carbon\Carbon::parse($date);
            $to_hour = $carbon_date_hour2->addHours(10);


            $calendar_item = new \App\Model\Calendar();
            $calendar_item->day_number = $i;
            $calendar_item->user_id = $user_id;
            $calendar_item->items = [];
            $calendar_item->package_id = null;
            $calendar_item->training_id = array_random($trainings,1)[0];
            $calendar_item->meal_id = null;
            $calendar_item->date = $date->addDay(1);
            $calendar_item->time_exercise_from = $from_hour;
            $calendar_item->time_exercise_to = $to_hour;
            $calendar_item->status = 'done';
            $calendar_item->type = 'training';
            $calendar_item->program_id = $program_id;
            $calendar_item->comment = $i;
            $calendar_item->description = $i;
            $calendar_item->save();

            $calendar_item = new \App\Model\Calendar();
            $calendar_item->day_number = $i;
            $calendar_item->user_id = $user_id;
            $calendar_item->items = [];
            $calendar_item->package_id = null;
            $calendar_item->training_id = array_random($trainings,1)[0];
            $calendar_item->meal_id = null;
            $calendar_item->date = $date;
            $calendar_item->time_exercise_from = $from_hour;
            $calendar_item->time_exercise_to = $to_hour;
            $calendar_item->status = 'done';
            $calendar_item->type = 'training';
            $calendar_item->program_id = $program_id;
            $calendar_item->comment = $i;
            $calendar_item->description = $i;
            $calendar_item->save();


            // Add a Food Package
            $calendar_item = new \App\Model\Calendar();
            $calendar_item->day_number = $i;
            $calendar_item->user_id = $user_id;
            $calendar_item->items = [];
            $calendar_item->package_id = array_random($packages,1)[0];
            $calendar_item->training_id = null;
            $calendar_item->meal_id = 1;
            $calendar_item->date = $date;
            $calendar_item->time_exercise_from = null;
            $calendar_item->time_exercise_to = null;
            $calendar_item->status = 'done';
            $calendar_item->type = 'package';
            $calendar_item->program_id = $program_id;
            $calendar_item->comment = $i;
            $calendar_item->description = $i;
            $calendar_item->save();


        }

    }
}
