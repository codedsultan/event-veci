@include('header')
  <!-- Header-->
<!-- <header class="relative mx-auto main-header" data-type="background" data-speed="7"> -->
<section class="text-gray-600 body-font h-screen flex bg-gray-900 bg-svg-constellation-gray-100 relative">
  <div class="container mx-auto flex px-5 py-12 items-center justify-center flex-col">
    <div class="lg:w-2/3 w-full animate-fade-in-down">
      <!-- Change the heading text -->
      <h1 class="md:text-6xl text-3xl mb-2 font-bold text-white tracking-tight leading-tight">
            Get Inspired and Put Yourself Out there
      </h1>
      <!-- Change the subheading text -->
      <!-- <h1 class="md:text-6xl text-3xl mb-4 font-bold text-white tracking-tight leading-tight">
        I’m here to assist <span class="border-b-4 border-green-400 -mb-20"></span>with your questions.
      </h1> -->
      <!-- Change the paragraph text -->
      <p class="mt-8 mb-16 md:leading-relaxed leading-normal text-white tracking-tight text-xl">
        Attend exciting events to meet people, you only live once, do more of what you love
    </p>
      <!-- Update the button texts and links -->
      <a class="uppercase rounded-sm bg-red-400 font-bold text-white px-8 py-4 mx-auto mr-4 hidden md:inline"
        href="/fullcalender">Event Calender</a>
      <a class="uppercase rounded-sm bg-green-400 font-bold text-white px-8 py-4 mx-auto hidden md:inline"
        href="/events/create">Create An Event</a>
    </div>
  </div>
  <a href="#show" class="absolute block mx-auto text-xl md:mt-96 bottom-0 left-1/2 -ml-10 mt-80">
    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd"
        d="M21.1716 29.1716C22.7337 27.6095 25.2663 27.6095 26.8284 29.1716L40 42.3431L53.1716 29.1716C54.7337 27.6095 57.2663 27.6095 58.8284 29.1716C60.3905 30.7337 60.3905 33.2663 58.8284 34.8284L42.8284 50.8284C41.2663 52.3905 38.7337 52.3905 37.1716 50.8284L21.1716 34.8284C19.6095 33.2663 19.6095 30.7337 21.1716 29.1716Z"
        fill="#FFFFFF"></path>
    </svg>
  </a>
</section>

    <!-- <div class="header_bg">
               <div class="main-header_text-box">
            <h1 class="heading-primary">
                 <span class="heading-primary_sub">The Real world is calling</span>
              </h1>
              <p class="header-para">Attend exciting events to meet people, you only live once, do more of what you love</p>
            <a class="btn btn-info header-btn" href="/fullcalender">Event Calender</a>
              <a class="btn btn-info header-btn" href="/events/create">Create An Event</a>
            <br><br><br>

    </div>

        </div> -->

    <!-- </header> -->
    <div id="show"></div>
    <div class=" mt-5  mx-auto max-w-7xl">

       <!-- Tranding-->
        <p class="event-heading"><b>Trending Events</b></p>
        <div class="event-wrap">
         <div class="row">
           @foreach($trending as $event)
            <div class="col-lg-3 col-md-4 col-sm-6 text-center">
             <div class="event-panel">
              <div class="event">
               <a href="{{$event->path}}">
                <div class="event-img">
                        <img src="{{$event->img}}" alt="">
                    </div>
                    <div class="event-text">
                    <div class="event-time">
                        <p><i class="far fa-clock"></i><span>{{$event->strtdt}} ,</span><span>{{$event->strttm}} </span></p>
                    </div>
                    <p class="event-name">{{$event->name}}</p>
                    <p class="event-location">{{$event->loc}}</p>
                    </div>
                </a>
                </div>
                </div>
            </div>
             @endforeach
         </div>
        </div>
                 <!-- All Events-->
        <p class="event-heading mt-5"><b>Events</b></p>
        <div class="mx-auto max-w-7xl ">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                @foreach($events as $event)
                    @include('event.list') <!--import event list -->
                @endforeach
         </div>
        </div>
    <div class="text-center">
        <a href="/events" class="btn event-btn">Show All Events >></a>
    </div>
                   <!-- All Topics-->
        <!-- <p class="event-heading"><b>Topics</b></p>
        <p><b>Browse groups by topics you're interested in.</b></p>
        <div class="event-wrap">
        <div class="row">
        @foreach($topics as $topic)
      <div class="col-lg-3 col-md-4 col-sm-6 text-center">
              <div class="mb-5">
               <a href="topic/{{$topic->slug}}">
                <div class="topic" style= "background-image: url('{{$topic->image}}'); background-position: center center;">
                   </div>
                   <div class="topic-name">{{$topic->name}}</div>
                </a>
          </div>
            </div>
            @endforeach
        </div>
        </div> -->
        <div class="max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded-lg">
            <h2 class="text-lg font-semibold mb-4">Topics</h2>
            <p><b>Browse groups by topics you're interested in.</b></p>
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach($topics as $topic)
                    <a href="topic/{{$topic->slug}}" class="p-2 px-3 border-purple-800 mb-4 rounded font-medium hover:bg-transparent hover:border-purple-800 border bg-purple-400/25 text-purple-800">{{$topic->name}}</a>
                @endforeach
                <!-- <a href="#" class="bg-green-200 hover:bg-green-300 py-1 px-2 rounded-lg text-sm">Programming</a>
                <a href="#" class="bg-yellow-200 hover:bg-yellow-300 py-1 px-2 rounded-lg text-sm">Web Development</a>
                <a href="#" class="bg-indigo-200 hover:bg-indigo-300 py-1 px-2 rounded-lg text-sm">Design</a>
                <a href="#" class="bg-purple-200 hover:bg-purple-300 py-1 px-2 rounded-lg text-sm">AI</a>
                <a href="#" class="bg-pink-200 hover:bg-pink-300 py-1 px-2 rounded-lg text-sm">Machine Learning</a> -->
            </div>
        </div>
    </div>
            <subscribe></subscribe>
            </div>
@include('footer')
