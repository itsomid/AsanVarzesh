

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title></title>
</head>
<body>
<?php

use SoapClient;

if($_POST['referenceId'] !="")
{
    $client = new SoapClient('https://ikc.shaparak.ir/XVerify/Verify.xml', array('soap_version'   => SOAP_1_1));
    $params['token'] =  $_POST["token"]; // please replace currentToken
    $params['merchantId'] = "A4CA";
    $params['referenceNumber'] = $_POST['referenceId'];
    $params['sha1Key'] = '22338240992352910814917221751200141041845518824222260';
    $result = $client->__soapCall("KicccPaymentsVerification", array($params));


}
else
{

    $client = new SoapClient('https://ikc.shaparak.ir/XToken/Tokens.xml', array('soap_version'   => SOAP_1_1));

    $params['amount'] = "2060";
    $params['merchantId'] = "J5E7";
    $params['invoiceNo'] = "12345678";
    $params['paymentId'] = "12345678";
    $params['specialPaymentId'] = "123456789123";
    $params['revertURL'] = "http://asanvarzesh.online/payment.php";
    $params['description'] = "aaaaa";
    $result = $client->__soapCall("MakeToken", array($params));



    ?>

    <form method="post" action="https://ikc.shaparak.ir/TPayment/Payment/index">
        <p><input type ="hidden" name ="token" value="<?php print  $result->MakeTokenResult->token?>" ></p>
        <p><input type ="text" name ="merchantId"  value="J5E7"></p>
        <p><input type ="submit" value="DoPayment" ></p>
    </form>

    <?php
}
?>

</body>
</html>

