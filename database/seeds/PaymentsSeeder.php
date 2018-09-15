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

            $payment = new \App\Model\Payment();
            $payment->user_id = $program->user_id;
            $payment->program_id = $program->id;
            $payment->coach_id = $program->coach_id;
            $payment->subscription_id = $program->subscription_id;
            $payment->price = 25000;
            $payment->via = 'Iran Kish';
            $payment->status = 'success';
            $payment->reference_id = md5(time());
            $payment->promotion_id = null;
            $payment->save();

        }

    }
}
