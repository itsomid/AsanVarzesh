<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>آسان ورزش</title>
    <link type="text/css" rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            var scrolllink = $(".scroll");
            scrolllink.click(function (e) {
                e.preventDefault();
                $('body,html').animate({
                    scrollTop:$(this.hash).offset().top
                })
            })

        })
    </script>

</head>
<body>
<div class="container">


    <div class="header">
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

        <div class="Av-application">
            <span class="Av">اپلیکیشن آو</span>
            <span class="info-Av">تناسب اندام را با حرفه ای ها شروع کنید</span>
            <div class="test-btn">
                <a class="scroll" href="#download">
                    می خواهم امتحان کنم
                </a>
            </div>
        </div>
    </div>



    <div class="content">
        <div class="Av-content">
            <span class="benefits-Av">
                آو چیست؟
            </span>
            <span class="about-one">
                توضیح در مورد سیستم آو
            </span>
        </div>
        <div class="img-mobile">
            <img src="images/App.png">
        </div>
    </div>




    <div class="information-Av">
        <div class="logo-img">
            <img src="images/Logo.png">
        </div>
        <div class="information one">
            <span class="title-information">
                آو همراه تندرستی
            </span>
            <span class="title2">
                جامعه سلامت، جامعه سفید
            </span>
            <span class="about">
                موسسه رایان راحیل ایرانیان تحت برند آسان ورزش و آو فعالیت خود را در پروژه آسان ورزش از سال ۱۳۹۵ آغاز نمود و همچنین از ابتدای سال ۱۳۹۷ فعالیت رسمی آو را در کنار فدراسیون بدنسازی و پرورش اندام شروع شد، اپلیکیشن آو اهداف بلندی را دنبال می کند که تمامی این اهداف همگی همسو با منافع فدراسیون ها، مربیان و جامعه مخاطبین آنها یعنی ورزشکاران می باشند، همینطور آو سیاست پیروی کامل از قوانین رسمی جاری کشور را دنبال می کند، لذا همه فعالیت ها به صورت کاملا قانونی و با دریافت مجوزهای لازم صورت گرفته است. آو با شعار جامعه سلامت جامعه سفید، رویای داشتن یک جامعه بزرگ ورزشکار و سلامت رو دنبال می کند و معتقد هستیم که هر فردی از روزی که به دنیا می آید، تا روزی که از دنیا می رود، می تواند با داشتن یک مربی ورزشی، یک کارشناس تغذیه و یک متخصص حرکت های اصلاحی زندگی سرشار از سلامتی را تجربه نماید، به همین دلیل آو را همراه سلامتی مردم فهمیم ایران می دانیم. لازم به ذکر است که فعالیت اپلیکیشن آو به همراه ایستگاهای سلامت و دستبندهای هوشمند که به ترتیب رونمایی خواهند شد ، یک فعالیت بین المللی خواهد بود و به زودی در چندین کشور فعالیت رسمی خود را آغاز خواهد نمود.
            </span>
        </div>
    </div>



    <div class="options">
        <div class="title-div">
            <span class="options-title">
                ویژگی های منحصر به فرد
            </span>
            <ol class="numbers">
                <li>برنامه روزانه ورزشی با حرفه ای ترین مربی‌ها</li>
                <li>ردیابی تمرینات و نظارت بر پیشرفت تمرینات توسط مربی</li>
                <li>امکان شرکت در رشته های ورزشی متنوع به صورت همزمان</li>
                <li>برنامه غذایی تحت نظر متخصص تغذیه </li>
                <li>مشاوره آنلاین با مربی،‌متخصص تغذیه و پزشک اصلاحی</li>
                <li>اندازه گیری میزان دویدن</li>
            </ol>
        </div>
    </div>



    <div class="information-Av">
        <div class="logo-img">
            <img src="images/Logo.png">
        </div>
        <div class="information one">
            <span class="title-information">
                تماس با ما
            </span>
            <span class="title2">
                تلفن های تماس :
            </span>
            <span class="about address">
                02188957701 - 02188958399 - 02188957793 - 02188959072 - 02188957760
            </span>
            <span class="title2">
                آدرس :
            </span>
            <span class="about address">
                میدان جهاد، خیابان شهید گمنام، پلاک ۱۴، واحد ۱۱ و ۱۲، طبقه ۶
            </span>
        </div>


    </div>



    <div id="download" class="application-download">
        <div class="div-application">
            <div class="logo-application">
                <img src="images/user@3x@2x.png">
                <span>Av training</span>
            </div>
            <div class="links">
                <span>تناسب اندام راهمین امروز<br>
با نصب اپلیکیشن آو شروع کنید
                </span>
                <div class="app-img">
                    <a href="apps/av_user_release_v1.0.8.apk" download>
                        <img class="cafe-bazaar" src="images/Group%203.png">
                    </a>

                    <a href="https://sibche.com/applications/asanvarzesh">
                        <img src="images/Group%204.png">
                    </a>
                </div>
            </div>
        </div>
    </div>



    <div class="last-page">
        <div class="right">
            <span>متخصصان<br> با اپلیکیشن مربی<br> در هر لحظه با<br>.شما همراه هستند </span>
            <a href="coach.html">
                <div>مربی هستم</div>
            </a>
        </div>
        <div class="left">
            <img src="images/Morabi.png">
        </div>
    </div>



    @include('footer')
</div>

</body>
</html>
