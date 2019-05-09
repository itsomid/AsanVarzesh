<!doctype html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>آسان ورزش</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:600" rel="stylesheet">
    <link rel="stylesheet" href={{url('assets/css/style.css')}} />
    <style>
        body,html {
            font-family: 'Vazir', sans-serif;
        }
        h1 {
            font-family: 'Vazir', sans-serif;
            font-size: 25px;
            margin-bottom: 20px;
        }
        .callback-box {
            width: 320px;
            padding: 15px;
            text-align: center;
            border-radius: 10px;
            border: 1px solid #eee;
            display: block;
            margin: 10px auto;
        }
        .back-to-app {
            padding: 10px 20px;
            color: white;
            background: #34B8C7;
            border-radius: 21px 21px;
            font-weight: bold;
            display: inline-block;
        }
        .back-to-app:hover {
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="callback-box">
            <h1>{{$payment->gateway_message}}</h1>
            <p>مبلغ: {{$payment->price}} ریال</p>
            <p>کدپیگیری: {{$payment->reference_id}}</p>
            <a href="#" class="back-to-app">بازگشت به آسان ورزش</a>
        </div>



    </div>
</body>
</html>
