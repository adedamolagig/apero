<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
         <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-85350869-3"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());

              gtag('config', 'UA-85350869-3');
            </script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MovingPiles</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                background: url(../images/home_bg.jpeg);
                background-size: 100%;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .top-left {
                position: absolute;
                left: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                font-weight: bold;
                font-family: Chalkduster, fantasy;
                color: white;
            }

            .links > a {
                color: white;
                padding: 0 25px;
                font-size: 20px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .animated {
                color: white;   
                width: 100%;
                height: 100px;
                text-align: justify;
                position: relative;

            }
        </style>
        
    </head>
    <body>
        
        
        <div class="flex-center position-ref full-height">
            <div class="top-left links">
                <a href="/threads">All Threads </a>    
            </div>
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Moving Piles
                    <!--this part needs a few correction for auth-->
                    <div class="title links">

                        <a href="{{ route('login') }}">Login <i class="fa fa-car fa-4x"></i></a>
                        

                    </div>

                    <!-- <div>
                        <img src="/images/streetart2.jpg" class="w3-round" alt="Norway">
                    </div> -->
                </div>

                <div class="content animated">
                  
                  <h3>Movingpiles is a platform for the expression of all issues of everyday life; whether real, fictional, personal or imaginative. it is a no holds barred arena to learn, discover, build, connect and evolve and feel the universal diversity and oneness. </h3>
                </div>
            </div>
        </div>
    </body>
</html>
