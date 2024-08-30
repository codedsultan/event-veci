<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="shortcut icon" type="image/png" href="{{asset('/images/logo.png')}}">



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EventVeci || Event Application</title>
    <!-- Scripts -->

    <meta name="description" content="Event Website development with laravel,scss,vuejs & tdd">
    <meta name="keyword" content="EventVeci,Event,Meetup,Backend,Laravel,VueJs,Tdd">

    <!-- <script type="text/javascript" src="https://addevent.com/libs/atc/1.6.1/atc.min.js" async defer></script> -->
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
     .event:before{
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


     }
</style>
@endforeach

    </head>
    <body id="app">
        <div class="text-center">
            <section class="w-full px-8 text-white bg-white ">
                <div class="container flex flex-col flex-wrap items-center justify-between py-5 mx-auto md:flex-row max-w-6xl">
                    <div class="flex flex-col lg:w-1/6 md:flex-row">
                        <a href="#_" class=" flex items-center mb-5 font-medium text-veci lg:w-auto lg:items-center lg:justify-center md:mb-0">
                            <img src="{{asset('/images/logo.png')}}" alt="" class="w-48 lg:w-40">
                            <!-- <span class="mx-auto text-xl font-black leading-none text-veci select-none">VECI<span class="text-indigo-600">.</span></span> -->
                        </a>

                        <!-- <nav class="flex flex-wrap items-center lg:w-3/4 float-right font-normal mb-5 text-sm md:mb-0 md:pl-8 lg:justify-center md:ml-8 md:border-l md:border-gray-200 uppercase">
                            <a href="#_" class="mr-5 leading-6 text-gray-600 hover:text-veciprimary">Home</a>
                            <a href="#_" class="mr-5 leading-6 text-gray-600 hover:text-veciprimary">About us</a>
                            <a href="#_" class="mr-5 leading-6 text-gray-600 hover:text-veciprimary">Services</a>
                            <a href="#_" class="mr-5 leading-6 text-gray-600 hover:text-veciprimary">Contact Us</a>
                        </nav> -->
                    </div>
                    <div class="flex flex-wrap">
                        @if(Auth::user() && Auth::user()->isAdmin())
                            <router-link to="/eventx-dashboard" class="px-3 py-1 text-sm leading-6 text-gray-900">
                                <p><i class="fas fa-desktop desktop"></i><span> Dashboard</span></p>
                            </router-link>
                            <router-link to="/manage-users" class="px-3 py-1 text-sm leading-6 text-gray-900">
                                <p><i class="fas fa-users-cog cog"></i><span> Manage Users </span></p>
                            </router-link>
                            <router-link to="/manage-topics" class=" px-3 py-1 text-sm leading-6 text-gray-900">
                            <p><i class="fas fa-globe-europe globe"></i><span> Manage Topics</span></p>
                            </router-link>
                            <router-link to="/manage-events" class=" px-3 py-1 text-sm leading-6 text-gray-900">
                                <p><i class="far fa-calendar-check em"></i><span> Manage Events </span></p>
                            </router-link>
                            <router-link to="/manage-tickets" class=" px-3 py-1 text-sm leading-6 text-gray-900">
                                <p><i class="fas fa-ticket-alt tm"></i><span> Manage Tickets </span></p>
                            </router-link>
                        @endif
                    </div>
                    <!-- <div class=" flex flex-col lg:w-4/6 md:flex-row">
                        <nav class="flex flex-wrap items-center lg:w-3/4 float-right font-normal mb-5 text-sm md:mb-0 md:pl-8 lg:justify-center md:ml-8 md:border-gray-200 uppercase">
                            <a href="#_" class="mr-5 leading-6 text-gray-600 hover:text-veciprimary">Home</a>
                            <a href="#_" class="mr-5 leading-6 text-gray-600 hover:text-veciprimary">About us</a>
                            <a href="#_" class="mr-5 leading-6 text-gray-600 hover:text-veciprimary">Services</a>
                            <a href="#_" class="mr-5 leading-6 text-gray-600 hover:text-veciprimary">Contact Us</a>
                        </nav>
                    </div> -->
                    @if (Route::has('login'))
                        <div class="flex items-center justify-end gap-x-4 lg:gap-x-6">
                            <!-- <div class="hidden md:block items-center  lg:w-1/6 lg:justify-end uppercase"> -->
                            @auth
                            <bell-notifications ></bell-notifications>
                            <profile-dropdown :user="{{ Auth::user() }}" v-cloak>
                                <template v-slot:trigger>
                                            {!!substr(strip_tags(Auth::user()->name ), 0, 10)!!}

                                </template>

                                <template v-slot:items>

                                            @if(Auth::user()->isAdmin())
                                            <!-- <MenuItem  v-slot=""> -->
                                                <a href="/eventx-dashboard" class="block px-3 py-1 text-sm leading-6 text-gray-900"><i class="fab fa-dashcube"></i> Dashboard</a>
                                            <!-- </MenuItem> -->
                            <!-- <a class="vue-dropdown_item_list" href="/eventx-dashboard"><i class="fab fa-dashcube"></i> Dashboard</a> -->
                            @endif

                            <a class="block px-3 py-1 text-sm leading-6 text-gray-900" href="profile/{{ Auth::user()->id }}"><i class="fas fa-user"></i> My Profile</a>
                            <a href="/myevents" class="block px-3 py-1 text-sm leading-6 text-gray-900"><i class="fas fa-cogs"></i>My Events</a>
                             <a class="block px-3 py-1 text-sm leading-6 text-gray-900" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                      <i class="fas fa-sign-out-alt"></i>  {{ __('Logout') }}
                                    </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                                </template>
                            </profile-dropdown>
                            <!-- <notifications class=""></notifications> -->

                            @else
                                <a href="{{ route('login') }}" class="text-gray-900">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-gray-900">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </section>

