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
    public $merchantId = 'J5E7';
    public $sha1 = '22338240992352910814917221751200141041845518824222260';

    public function MoreThan100messages($message) {
        switch ($message)
        {
            case 110:
                return " انصراف دارنده کارت";
                break;
            case 120:
                return"   موجودی کافی نیست";
                break;
            case 130:
            case 131:
            case 160:
                return"   اطلاعات کارت اشتباه است";
                break;
            case 132:
            case 133:
                return"   کارت مسدود یا منقضی می باشد";
                break;
            case 140:
                return" زمان مورد نظر به پایان رسیده است";
                break;
            case 200:
            case 201:
            case 202:
                return" مبلغ بیش از سقف مجاز";
                break;
            case 166:
                return" بانک صادر کننده مجوز انجام  تراکنش را صادر نکرده";
                break;
            case 150:
            default:
                return " خطا بانک  $message";
                break;
        }
    }

    public function lessThan100Message($message) {
        switch ($message)
        {
            case '-20':
                return "در درخواست کارکتر های غیر مجاز وجو دارد";
                break;
            case '-30':
                return " تراکنش قبلا برگشت خورده است";
                break;
            case '-50':
                return " طول رشته درخواست غیر مجاز است";
                break;
            case '-51':
                return " در در خواست خطا وجود دارد";
                break;
            case '-80':
                return " تراکنش مورد نظر یافت نشد";
                break;
            case '-81':
                return " خطای داخلی بانک";
                break;
            case '-90':
                return "تراکنش قبلا تایید شده است";
                break;
        }
    }

    public function getToken($amount,$program_id,$payment_id) {

        $client = new \SoapClient('https://ikc.shaparak.ir/XToken/Tokens.xml', array('soap_version'   => SOAP_1_1));
        $params['amount'] =  $amount;
        $params['merchantId'] = $this->merchantId;
        $params['invoiceNo'] = $payment_id;
        $params['paymentId'] = $payment_id;
        $params['specialPaymentId'] = $payment_id;
        $params['revertURL'] = 'http://asanvarzesh.online/api/v1/user/payments/callback/';
        $params['description'] = "program_id: ".$program_id;
        $result = $client->__soapCall("MakeToken", array($params));
        return $result->MakeTokenResult->token;
    }

    public function verifyPayment($token,$reference_id) {
        $client = new SoapClient('https://ikc.shaparak.ir/XVerify/Verify.xml', array('soap_version'   => SOAP_1_1));
        $params['token'] =  $token;
        $params['merchantId'] = $this->merchantId;
        $params['referenceNumber'] = $reference_id;
        $params['sha1Key'] = $this->sha1;
        $result = $client->__soapCall("KicccPaymentsVerification", array($params));
        return $result->KicccPaymentsVerificationResult;
    }

    function redirectPost($url, array $data)
    {

        echo '<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<title>در حال اتصال ...</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
	#main {
	    background-color: #F1F1F1;
	    border: 1px solid #CACACA;
	    height: 90px;
	    left: 50%;
	    margin-left: -265px;
	    position: absolute;
	    top: 200px;
	    width: 530px;
	}
	#main p {
	    color: #757575;
	    direction: rtl;
	    font-family: Arial;
	    font-size: 16px;
	    font-weight: bold;
	    line-height: 27px;
	    margin-top: 30px;
	    padding-right: 60px;
	    text-align: right;
	}
    </style>
        <script type="text/javascript">
            function closethisasap() {
                document.forms["redirectpost"].submit();
            }
        </script>
    </head>
    <body onload="closethisasap();">';
        echo '<form name="redirectpost" method="post" action="'.$url.'">';

        if ( !is_null($data) ) {
            foreach ($data as $k => $v) {
                echo '<input type="hidden" name="' . $k . '" value="' . $v . '"> ';
            }
        }

        echo' </form><div id="main">
<p>درحال اتصال به درگاه بانک</p></div>
    </body>
    </html>';

        exit;
    }

}
