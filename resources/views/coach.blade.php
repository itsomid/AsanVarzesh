<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>مربیان</title>
    <link href="css/stylesheet.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="header coach">

        <div class="logo">
            <img src="images/Logotype.png">
        </div>

        <div class="info">
            <a class="text-header" href="{{route('home')}}">
                صفحه اصلی
            </a>
            <a class="text-header" href="{{route('experts')}}">
                کارشناسان تغذیه
            </a>
            <a class="text-header" href="{{route('specialists')}}">
                متخصصین
            </a>
            <a href="{{route('coach')}}" class="text-header">
                مربیان
            </a>
            <a href="{{route('rules/av')}}" class="text-header">
                شرایط و قوانین
            </a>

        </div>

        <div class="div-benefits-Av">

            <span class="benefits-Av">
مزایای کار در آو

            </span>
            <span class="benefits-Av title">
شرایط عضویت در سامانه مربیان اپلیکیشن آو:

            </span>
            <span class="about-Av">
رئیس خود باشید.

            </span>
            <span class="about two">
به سادگی از طریق اپلیکیشن آو به هزاران درخواست تناسب اندام پاسخ دهید و در هر مکانی درآمدزایی کنید، یک ارائه بهبود آسیب و حرکت های اصلاحی علمی را تجربه کنید .

            </span>
            <span class="about-Av">
درآمد بالاتری داشته باشید.

            </span>
            <span class="about two">
از طریق اپلیکیشن آو درآمد زیادی کسب کنید، به سادگی می تونید به همه ورزشکاران و یا مخاطبین حضوری یا غیر حضوری برنامه حرکت های اصلاحی بدهید و حتی با بررسی و تایید هر پرونده ورزشکاری حتی اعضایی که سالم هستند، پورسانت دریافت کنید همچنین به سادگی تمامی نیاز مخاطبین خود را از طریق آو تامین می گردد، از این طریق می تونید همراه با دریافت شهریه عالی حتی از پورسانت بالای هر خرید مخاطب خود از تجهیزات ورزشی خود درآمد عالی داشته باشید.

            </span>
            <span class="about-Av">
تسهیلات ویژه دریافت کنید.

            </span>
            <span class="about two">
از پیشنهادهای ویژه برای متخصصین آو بهره‌مند شوید؛ پیشنهادهایی برای کسب درآمد و رفاه بیش‌تر.طرح‌های تشویقی، جایزه‌ها و خدماتی که آو برای کارشناسان در نظر می‌گیرد، پیوسته رو به بهبود است و کیفیت زندگی حرفه‌ای شما را تحت‌تاثیر قرار می‌دهد.

            </span>

            <div class="button-download">

                <a href="apps/av_coach_release_v1.0.11.apk" download target="_blank">
                    <div class="download-coach-app android">
                        <i class="fab fa-android"></i>
                        دانلود اپلیکیشن مربی
                    </div>
                </a>
                <a href="https://sibche.com/applications/asanvarzesh-couch" target="_blank">
                    <div class="download-coach-app ios">
                        <i class="fab fa-apple"></i>
                        دانلود اپلیکیشن مربی
                    </div>
                </a>
            </div>

        </div>
    </div>

    @include('footer')
</div>

</body>
</html>