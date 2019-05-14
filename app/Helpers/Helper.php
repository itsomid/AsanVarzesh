<?php


namespace App\Helpers;


class Helper
{
    public static function homePageURL()
    {
        return url('/');
    }

    public function convert($input)
    {
        $arabic = array('۰', '۱', '۲', '۳', '٤', '٥', '٦', '۷', '۸', '۹');
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        $string = str_replace($arabic, $english , $input);
        $string = str_replace($persian, $english , $string);

        return $string;
    }

    public static function sendSMS($to,$msg)
    {
        $options = [
            'verify' => false,
            'timeout' => 0
        ];
        $url = "https://api.kavenegar.com/v1/6362557965644E54612B7951546679346734676B4B42576E58786969752B356A/sms/send.json";
        $number = "1000596446";
        $client = new \GuzzleHttp\Client($options);
        $response = $client->request('POST', $url, [
            'form_params' => [
                'receptor' => $to,
                'sender' => $number,
                'message' => $msg
            ]
        ]);
        return $response;
    }

}