<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- <link rel="shortcut icon" type="image/png" href="{{asset('img/logo.png')}}"> -->



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EventVeci || Event Application</title>
    <!-- Scripts -->

    <meta name="description" content="Event Website development with laravel,scss,vuejs & tdd">
    <meta name="keyword" content="EventVeci,Event,Meetup,Backend,Laravel,VueJs,Tdd">

    <script type="text/javascript" src="https://addevent.com/libs/atc/1.6.1/atc.min.js" async defer></script>
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5e0238b188092b001215bb24&product=inline-share-buttons" async="async"></script>



<!-- Compiled and minified JavaScript -->
          <!-- @yield('javascript') -->
           <script>
    window.App={!! json_encode([
                'csrfToken'=>csrf_token(),
                'user'=>Auth::user(),
                'signedIn'=>Auth::check()
                ]) !!};
    </script>

          <script src="https://cdn.tiny.cloud/1/dvtavx74nw7o1b3z7q3d5hi9thrc3feptxfydctl1shlggz5/tinymce/5/tinymce.min.js" ></script>




        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <!-- Styles -->

    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


     <!-- <link rel="stylesheet" href="{{asset('css/iziToast.min.css')}}"> -->

        <!-- Styles -->
        <style>
            /* html, body {

                font-weight: 200;
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

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #ffffff;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            } */
        </style>
        @foreach($events as $event)
 <style>
     /* .event:before{
         position: absolute;
         content:"${{$event->price}}";
         top: 0;
         right:-35px;
         width:150px;
         height: 40px;
         line-height: 40px;
         text-align: center;
         transform: rotate(30deg);
         background-color:#2D395D ;
         color:#ffffff;


     } */
</style>

 @endforeach
    </head>
    <body id="">
       <div id="app" class="text-center">

           <div id="nav" class="nav mx-auto max-w-7xl">
            @if (Route::has('login'))
                <div class="block">
                    @auth

                    <profile-dropdown class="float-right"  v-cloak>
                        <template v-slot:trigger>

                                    {!!substr(strip_tags(Auth::user()->name ), 0, 10)!!}

                        </template>
                    </profile-dropdown>
                    <notifications class=""></notifications>

                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
