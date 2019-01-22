<?php

use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $programs = \App\Model\Programs::where('status','!=','orphan')->get();
        foreach ($programs as $program)
        {
            $coach_sport = \App\Model\Coach_sport::where('sport_id',$program['sport_id'])->where('coach_id',$program['coach_id'])->first();

            $price = $coach_sport->price;
            $insurance = 20000;
            $tax = $price * 0.09;
            $coach = ($price) * 0.6;
            $corrective = ($price) * 0.075;
            $nutrition = ($price) * 0.25;
            $total = ($price+$tax) + $insurance;

            // User
            $payment = new \App\Model\Payment();
            $payment->user_id = $program->user_id;
            $payment->program_id = null;
            $payment->coach_id = null;
            $payment->subscription_id = null;
            $payment->price = $total;
            $payment->type = 'credit';
            $payment->via = 'Iran Kish';
            $payment->status = 'success';
            $payment->reference_id = md5(time());
            $payment->promotion_id = null;
            $payment->save();

            // Coach
            $payment = new \App\Model\Payment();
            $payment->program_id = $program->id;
            $payment->coach_id = $program['coach_id'];
            $payment->subscription_id = null;
            $payment->price = $coach;
            $payment->type = 'credit';
            $payment->via = null;
            $payment->status = 'success';
            $payment->reference_id = md5(time());
            $payment->promotion_id = null;
            $payment->save();

            // Corrective
            $payment = new \App\Model\Payment();
            $payment->program_id = $program->id;
            $payment->corrective_doctor_id = $program->corrective_doctor_id;
            $payment->subscription_id = null;
            $payment->price = $corrective;
            $payment->type = 'credit';
            $payment->via = null;
            $payment->status = 'success';
            $payment->reference_id = md5(time());
            $payment->promotion_id = null;
            $payment->save();

            // Nutrition
            $payment = new \App\Model\Payment();
            $payment->program_id = $program->id;
            $payment->nutrition_doctor_id = $program->nutrition_doctor_id;
            $payment->subscription_id = null;
            $payment->price = $nutrition;
            $payment->type = 'credit';
            $payment->via = null;
            $payment->status = 'success';
            $payment->reference_id = md5(time());
            $payment->promotion_id = null;
            $payment->save();


            $payment = new \App\Model\Payment();
            $payment->user_id = $program->user_id;
            $payment->program_id = $program->id;
            $payment->subscription_id = $program->subscription_id;
            $payment->price = $total;
            $payment->type = 'debit';
            $payment->via = null;
            $payment->status = 'success';
            $payment->reference_id = null;
            $payment->promotion_id = null;
            $payment->save();

        }

    }
}
