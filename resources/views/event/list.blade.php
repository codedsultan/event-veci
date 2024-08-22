     <!-- <div class="col-lg-3 col-md-4 col-sm-6 text-center">
             <div class="event-panel">
              <div class="event">
               <a href="{{$event->path()}}">
                <div class="event-img">
                        <img src="{{$event->image_path}}" alt="">
                    </div>
                    <div class="event-text">
                    <div class="event-time">
                        <p><i class="far fa-clock"></i><span> {{$event->startdate}},</span><span> {{$event->strttm}}</span></p>
                    </div>
                    <p class="event-name">{{$event->name}}</p>
                    <p class="event-location">{{$event->location}}</p>
                    </div>
                </a>
                </div>
                </div>
            </div> -->


            <div class="relative event text-center col-span-1 space-x-4 bg-white rounded-3xl mx-4 md:mx-auto border-2 border-gray-800 mt-8">
                <div class="px-8 py-6 md:p-10">
                <a href="{{$event->path()}}">
                    <h1 class="text-4xl md:text-2xl max-w-[200px] font-medium leading-tight text-gray-800 mb-6">{{$event->name}}</h1>
                    <p class="text-base md:text-lg font-normal leading-normal text-gray-800 mb-6"><i class="far fa-clock"></i><span> {{$event->startdate}},</span><span> {{$event->strttm}}</span></p>
                    <div class="flex justify-center">
                        <a href="" target="_blank" rel="noopener"
                            class="bg-yellow-400 rounded-lg text-gray-800 font-medium text-base md:text-lg py-3 px-8 md:px-12 hover:bg-yellow-500 transition-all duration-150 ease-in-out">Register
                            now
                        </a>
                    </div>
                    <p class="text-base md:text-lg font-normal leading-normal text-gray-800 mt-6">{{$event->location}}</p>
                    <!-- <p class="text-sm md:text-base font-normal leading-normal text-gray-800 mt-2">Google I/O 2023 is around the
                        corner! Tune in to watch the livestreamed keynotes at 10am PT, then dive into 100+ technical sessions,
                        codelabs, and more, on demand. Learn about...
                    </p> -->
                </a>
                </div>
            </div>

