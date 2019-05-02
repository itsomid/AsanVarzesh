<?php
/**
 * Created by PhpStorm.
 * User: Ali A. Jafari
 * Date: 9/8/2018
 * Time: 7:12 PM
 */
namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class IranKish
{
    public $getToken = 'https://ikc.shaparak.ir/XToken/Tokens.xml';

    public function getToken() {
        $params['amount'] = 100;
        $params['merchantId'] = '02013314';
        $params['invoiceNo'] = time();
        $params['paymentId'] = time();
        $params['specialPaymentId'] = time();
        $params['revertURL'] = 'http://google.com';
        $params['description'] = "";

        $options = array(
            'cache_wsdl' => 0,
            'trace' => 1,
            'stream_context' => stream_context_create(array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            )
        ));

        $client = new \SoapClient('https://ikc.shaparak.ir/XToken/Tokens.xml', $options);

        $result = $client->__soapCall("MakeToken", array($params));
        $token = $result->MakeTokenResult->token;

        return var_dump($result);



    }
}