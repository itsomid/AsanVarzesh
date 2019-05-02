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
        $params['Amount'] = 2060;
        $params['MerchantId'] = 'J5E7';
        $params['InvoiceNumber'] = '2';
        $params['PaymentId'] = '3';
        $params['specialPaymentId'] = '2';
        $params['RevertURL'] = 'http://asanvarzesh.online';
        $params['Description'] = "test";
        $result = $client->__soapCall("MakeToken", array($params));
        return $result->MakeTokenResult->token;


    }
}
