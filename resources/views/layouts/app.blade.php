<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EventVeci || Event Application</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


         <script>
    window.App={!! json_encode([
                'csrfToken'=>csrf_token(),
                'user'=>Auth::user(),
                'signedIn'=>Auth::check()
                ]) !!};
    </script>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

    <!-- <link rel="shortcut icon" type="image/png" href="{{asset('img/Dream.png')}}"> -->


</head>
<body id="app">
   <!-- <div id="nav"></div>
   <div id="show"></div> -->
    <div >
        <main class="">
           <div class="container-fluid">
           <div class="row">
           <div class="col-md-3 text-center">
               <div class="panel">
                   <a href="/"><img src="{{asset('img/logo.png')}}"alt=""></a>
                <ul class="panel-list">
                  @if(Auth::user() && Auth::user()->isAdmin())
                   <router-link to="/eventx-dashboard" class="panel-list_item">
                       <p><i class="fas fa-desktop desktop"></i><span> Dashboard</span></p>
                    </router-link>
                    <router-link to="/manage-users" class="panel-list_item">
                        <p><i class="fas fa-users-cog cog"></i><span> Manage Users </span></p>
                    </router-link>
                    <router-link to="/manage-topics" class="panel-list_item">
                    <p><i class="fas fa-globe-europe globe"></i><span> Manage Topics</span></p>
                    </router-link>
                    <router-link to="/manage-events" class="panel-list_item">
                        <p><i class="far fa-calendar-check em"></i><span> Manage Events </span></p>
                    </router-link>
                    <router-link to="/manage-tickets" class="panel-list_item">
                        <p><i class="fas fa-ticket-alt tm"></i><span> Manage Tickets </span></p>
                    </router-link>
                @endif
                </ul>
               </div>
              </div>
           <div class="col-md-9 main-bg">

           @if(Auth::user())
           <dropdown class="float-right" v-cloak>
                      <template v-slot:trigger>
                               <a class="vue-dropdown-menu"><img src="{{Auth::user()->profile}}" alt="{{Auth::user()->name}}'s avatar" class="dropdown-img">

                                <span class="vue-dropdown-menu_name" href="#" role="button"  aria-haspopup="true" aria-expanded="false">
                                {!!substr(strip_tags(Auth::user()->name ), 0, 14)!!}

                                   </span></a>
                              </template>
                            <div class="vue-dropdown_up">
                            @if(Auth::user()->isAdmin())
                            <a class="vue-dropdown_item_list" href="/eventx-dashboard"><i class="fab fa-dashcube"></i> Dashboard</a>
                            @endif
                            <a class="vue-dropdown_item_list" href="profile/{{ Auth::user()->id }}"><i class="fas fa-user"></i> My Profile</a>
                            <a href="/myevents" class="vue-dropdown_item_list"><i class="fas fa-cogs"></i>My Events</a>
                             <a class="vue-dropdown_item_list" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                      <i class="fas fa-sign-out-alt"></i>  {{ __('Logout') }}
                                    </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
               </div>
           </dropdown>
           @endif
           @if(Auth::user())
           <router-view>

           </router-view>
            @else
            @yield('content')
            @endif
           </div>
           </div>
           </div>

        </main>
    </div>
</body>
</html>
