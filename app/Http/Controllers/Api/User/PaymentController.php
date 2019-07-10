<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Helper;
use App\Helpers\IranKish;
use App\Model\Coach_sport;
use App\Model\Payment;
use App\Model\Programs;
use App\User;
use App\Model\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

    public function index()
    {
        $user = auth('api')->user();
        $payments = Payment::with(['program.subscription','coach'])->where('user_id',$user->id)->orderby('id','DESC')->get();
        return response()->json($payments,200);
    }
    public function check($reference)
    {
        $payment = Payment::where('reference_id',$reference)->first();
        return response()->json($payment,200);
    }

    public function pay($program_id)
    {
        $payment = Payment::where('program_id',$program_id)->where('status','pending')->first();
        if(!$payment) {
            return response()->json([
                'Not Found'
            ],404);
        }

        $iranKish = new IranKish();
        $data['token'] = $payment->token;
        $data['merchantId'] = $iranKish->merchantId;
        return $iranKish->redirectPost('https://ikc.shaparak.ir/TPayment/Payment/index',$data);

    }

    public function callback(Request $request) {
        $data = $request->all();
        $iranKish = new IranKish();
        $payment = Payment::find($data['paymentId']);
        $program = Programs::find($payment->program_id);
        $coach = User::find($program->coach_id);
        $referenceId = isset($data['referenceId']) ? $data['referenceId'] : 0;
        $gateway_status = 0;

        if($data['resultCode'] == '100') {
            // Verify
            $result = $iranKish->verifyPayment($payment->token,$referenceId);
            if(floatval($result) > 0 && floatval($result) == (floatval($payment->price))*10) {

                // Successful Payment
                $status = 'success';
                $gateway_status = 100;
                $message = 'پرداخت موفقیت آمیز';

                $payment->status = $status;
                $payment->reference_id = $referenceId;
                $payment->gateway_status = $gateway_status;
                $payment->gateway_message = $message;
                $payment->save();

                $debit_payment = new Payment();
                $debit_payment->user_id = $program->user_id;
                $debit_payment->coach_id = $program->coach_id;
                $debit_payment->corrective_doctor_id = $coach->team['corrective_doctor'];
                $debit_payment->nutrition_doctor_id = $coach->team['nutrition_doctor'];
                $debit_payment->federation_id = $program->sport->federation->id;
                $debit_payment->program_id = $program->id;
                $debit_payment->price = $payment->price;
                $debit_payment->type = 'debit';
                $debit_payment->status = 'success';
                $debit_payment->promotion_id = null;
                $debit_payment->result_code = $data['resultCode'];
                $debit_payment->save();

                // Subscription
                $from = Carbon::today()->format('Y-m-d H:i:s');
                $to = Carbon::today()->addDay(30);
                $coach_sport = Coach_sport::where('sport_id',$program->sport_id)
                    ->where('coach_id',$program->coach_id)
                    ->first();

                $subscription = new Subscription();
                $subscription->user_id = $program->user_id;
                $subscription->from = $from;
                $subscription->to = $to;
                $subscription->program_id = $program->id;
                $subscription->coach_sport_id = $coach_sport->id;
                $subscription->save();

                $program->status = 'pending';
                $program->subscription_id = $subscription->id;
                $program->save();



                // Send Message To Coach
                Helper::sendSMS($coach->mobile,'یک پرونده ورزشی جدید برای شما ارسال شد.');


            } else{
                // Unsuccessfull Payment
                $status = 'failed';
                $gateway_status = $result;
                $message = $iranKish->lessThan100Message($result);

                $payment->gateway_status = $gateway_status;
                $payment->status = $status;
                $payment->gateway_message = $message;
                $payment->result_code = $data['resultCode'];
                $payment->reference_id = $referenceId;
                $payment->save();

                $program->status = 'cancel';
                $program->save();

            }
        } else {
            // Unsuccessfull Payment
            $status = 'failed';
            $gateway_status = $data['resultCode'];
            $message = $iranKish->moreThan100messages($data['resultCode']);

            $payment->gateway_status = $gateway_status;
            $payment->status = $status;
            $payment->gateway_message = $message;
            $payment->result_code = $data['resultCode'];
            $payment->save();

            $program->status = 'cancel';
            $program->save();

        }



        return view('gateway_callback', ['payment' => $payment]);
    }

    public function verifyPayment($reference_id,Payment $payment)
    {

        $iranKish = new IranKish();
        $check_credit = $payment->where('reference_id', $reference_id)->first();
        if ($check_credit) {
            $result = $iranKish->verifyPayment($check_credit->token, $check_credit->reference_id);

            if (floatval($result) > 0 && floatval($result) == (floatval($check_credit->price)) * 10) {
                // Successful Payment
                $status = 'success';
                $gateway_status = 100;
                $message = 'پرداخت موفقیت آمیز';
                $payment->status = $status;
                $check_credit->gateway_status = $gateway_status;
                $check_credit->gateway_message = $message;
                $check_credit->save();
                response()->json(['payment updated'],200);

            } else {
                response()->json(['payment updated'],400);
            }
        }

    }




}
