<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\IranKish;
use App\Model\Payment;
use App\Model\Programs;
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
        $referenceId = isset($data['referenceId']) ? $data['referenceId'] : 0;
        $gateway_status = 0;

        if($data['resultCode'] == '100') {
            // Verify
            $result = $iranKish->verifyPayment($payment->token,$referenceId);

            if(floatval($result) > 0 && floatval($result) == floatval($payment->price)) {

                // Successful Payment
                $status = 'success';
                $gateway_status = 100;
                $message = 'پرداخت موفقیت آمیز';

                $payment->status = $status;
                $payment->reference_id = $referenceId;
                $payment->gateway_status = $gateway_status;
                $payment->gateway_message = $message;
                $payment->save();

                $program->status = 'pending';
                $program->save();

            } else{
                // Unsuccessfull Payment
                $status = 'failed';
                $gateway_status = $result;
                $message = $iranKish->lessThan100Message($result);

                $payment->gateway_status = $gateway_status;
                $payment->status = $status;
                $payment->message = $message;
                $payment->save();
            }
        } else {
            // Unsuccessfull Payment
            $status = 'pending';
            $gateway_status = $data['resultCode'];
            $message = $iranKish->moreThan100messages($data['resultCode']);

            $payment->gateway_status = $gateway_status;
            $payment->status = $status;
            $payment->message = $message;
            $payment->save();

        }



        return view('gateway_callback', ['payment' => $payment]);
    }

}
