<?php
/**
 * Created by PhpStorm.
 * User: Ali A. Jafari
 * Date: 9/8/2018
 * Time: 7:12 PM
 */
namespace App\Helpers;
use SoapClient;

class IranKish
{
    public $getToken = 'https://ikc.shaparak.ir/TToken/Tokens.svc';
    protected $merchantId = 'J5E7';
    public $sha1 = '22338240992352910814917221751200141041845518824222260';

    public function getToken() {
        $params['Amount'] = 2060;
        $params['MerchantId'] = $this->merchantId;
        $params['InvoiceNumber'] = '1';
        $params['PaymentId'] = '1';
        $params['specialPaymentId'] = '1';
        $params['RevertURL'] = 'http://asanvarzesh.online';
        $params['Description'] = "test";

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

        $client = new SoapClient('https://ikc.shaparak.ir/XToken/Tokens.xml', $options);

        $result = $client->__soapCall("MakeToken", array($params));
        $token = $result->MakeTokenResult->token;
        return var_dump($token);



    }
}