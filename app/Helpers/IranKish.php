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
        $client = new \SoapClient('https://ikc.shaparak.ir/XToken/Tokens.xml', array('soap_version'   => SOAP_1_1));
        $params['amount'] =  2060;
        $params['merchantId'] = 'J5E7';
        $params['invoiceNo'] = 1;
        $params['paymentId'] = 1;
        $params['specialPaymentId'] = 1;
        $params['revertURL'] = 'http://asanvarzesh.online/result';
        $params['description'] = "";
        $result = $client->__soapCall("MakeToken", array($params));
        return $result->MakeTokenResult->token;


    }
}
