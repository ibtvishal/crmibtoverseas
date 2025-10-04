<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400|Montserrat:700' rel='stylesheet' type='text/css'>
    <style>
    @import url(//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css);
    @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:300);

    .inner {
        position: absolute;
        margin: auto;
        width: 50px;
        height: 95px;
        top: 0px;
        left: 0px;
        bottom: 0px;
        right: 0px;
    }

    .inner>div {
        width: 50px;
        height: 50px;
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 100%;
        position: absolute;
        transition: all 0.5s ease;
    }

    .inner>div:first-child {
        margin-left: -27px;
        animation: one 1.5s linear 1;
    }

    .inner>div:nth-child(2) {
        margin-left: 27px;
        animation: two 1.5s linear 1;
    }

    .inner>div:nth-child(3) {
        margin-top: 54px;
        margin-left: -27px;
        animation: four 1.5s linear 1;
    }

    .inner>div:nth-child(4) {
        margin-top: 54px;
        margin-left: 27px;
        animation: three 1.5s linear 1;
    }

    @keyframes one {
        0% {
            transform: scale(1);
        }

        25% {
            transform: scale(0.3);
        }

        50% {
            transform: scale(1);
        }

        75% {
            transform: scale(1.4);
        }

        100% {
            transform: scale(1);
        }
    }

    @keyframes two {
        0% {
            transform: scale(1.4);
        }

        25% {
            transform: scale(1);
        }

        50% {
            transform: scale(0.3);
        }

        75% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.4);
        }
    }

    @keyframes three {
        0% {
            transform: scale(1);
        }

        25% {
            transform: scale(1.4);
        }

        50% {
            transform: scale(1);
        }

        75% {
            transform: scale(0.3);
        }

        100% {
            transform: scale(1);
        }
    }

    @keyframes four {
        0% {
            transform: scale(0.3);
        }

        25% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.4);
        }

        75% {
            transform: scale(1);
        }

        100% {
            transform: scale(0.3);
        }
    }

    .inner>div.done {
        margin-left: 0px;
        margin-top: 27px;
    }

    .inner>div.page {
        transform: scale(40);
    }

    .pageLoad {
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100vh;
        background-color: #0A0A0A;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .pageLoad.off {
        opacity: 0;
        pointer-events: none;
    }

    .box {
        background: white;
        width: 80%;
        margin: auto;
        padding: 6px;
        text-wrap: wrap;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }

    @font-face {
        font-family: "Akkurat-Regular";
        src: url("../font/akkurat/lineto-akkurat-regular.eot");
        src: url("../font/akkurat/lineto-akkurat-regular.eot?#iefix") format("embedded-opentype"),
            url("../font/akkurat/lineto-akkurat-regular.woff") format("woff");
        font-weight: normal;
        font-style: normal;
    }

    .cf:before,
    .cf:after {
        content: " ";
        display: table;
    }

    .cf:after {
        clear: both;
    }

    * {
        box-sizing: border-box;
    }

    html {
        font-size: 16px;
        background-color: #fffffe;
    }

    body {
        padding: 0 20px;
        min-width: 300px;
        font-family: 'Akkurat-Regular', sans-serif;
        background-color: #fffffe;
        color: #1a1a1a;
        text-align: center;
        word-wrap: break-word;
        -webkit-font-smoothing: antialiased
    }

    a:link,
    a:visited {
        color: #00c2a8;
    }

    a:hover,
    a:active {
        color: #03a994;
    }

    .site-header {
        margin: 0 auto;
        padding: 80px 0 0;
        max-width: 820px;
    }

    .site-header__title {
        margin: 0;
        font-family: Montserrat, sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1.1;
        text-transform: uppercase;
        -webkit-hyphens: auto;
        -moz-hyphens: auto;
        -ms-hyphens: auto;
        hyphens: auto;
    }

    .main-content {
        margin: 0 auto;
        max-width: 820px;
    }

    .main-content__checkmark {
        font-size: 4.0625rem;
        line-height: 1;
        color: #24b663;
    }

    .main-content__body {
        margin: 20px 0 0;
        font-size: 1rem;
        line-height: 1.4;
        height: 120
    }

    .site-footer {
        margin: 0 auto;
        padding: 80px 0 25px;
        padding: 0;
        max-width: 820px;
    }

    .site-footer__fineprint {
        font-size: 0.9375rem;
        line-height: 1.3;
        font-weight: 300;
    }

    @media only screen and (min-width: 40em) {
        .site-header {
            padding-top: 150px;
        }

        .site-header__title {
            font-size: 2.25rem;
        }

        .main-content__checkmark {
            font-size: 9.75rem;
        }

        .main-content__body {
            font-size: 1.25rem;
        }

        .site-footer {
            padding: 145px 0 25px;
        }

        .site-footer__fineprint {
            font-size: 1.125rem;
        }
    }

    .button-back {
        background: #00c2a8;
        color: white !important;
        padding: 1% 10%;
        margin-top: 20%;
        text-decoration: none;
        font-weight: 400;
        border-radius: 5px;
    }
    </style>
    <script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/jquery-1.9.1.min.js"></script>
    <script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/html5shiv.js"></script>
</head>

<body style="background:#edf1f5">
    <div class="pageLoad">
        <div class="inner">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="box">
        <header class="site-header" id="header">
            <h1 class="site-header__title" data-lead-id="site-header-title">THANK YOU! <br>"Form Submitted"</h1>
        </header>

        <div class="main-content">
            <i class="fa fa-check main-content__checkmark" id="checkmark"></i>
            <p class="main-content__body" data-lead-id="main-content-body">Page will be redirect in <span
                    id="countdown"></span></p>
            <!-- <a href="visit-addf.php" class="button-back">Go Back</a> -->
        </div>

        <footer class="site-footer" id="footer">
            <p class="site-footer__fineprint" id="fineprint">2023 © Powered by IBT India Pvt Ltd</p>
        </footer>
    </div>
    <script>
    setTimeout(function() {
        $('.inner div').addClass('done');

        setTimeout(function() {
            $('.inner div').addClass('page');

            setTimeout(function() {
                $('.pageLoad').addClass('off');

                $('body, html').addClass('on');


            }, 500)
        }, 500)
    }, 1500)
    </script>
    <script>
    var timeleft = 7;
    var downloadTimer = setInterval(function() {
        if (timeleft <= 0) {
            window.location.href = "visit-addf.php"
        } else {
            document.getElementById("countdown").innerHTML = timeleft + " seconds";
        }
        timeleft -= 1;
    }, 1000);
    </script>
</body>

</html>