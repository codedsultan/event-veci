@include('header')
<script src="https://checkout.stripe.com/checkout.js"></script>
@include('event.map')
<div id="app" class="mx-auto max-w-7xl">
    <div class="mx-auto mt-12 max-w-7xl px-8">
        <div class="mx-auto flex max-w-2xl flex-col justify-between lg:mx-auto lg:max-w-7xl lg:flex-row">
            <div class="w-full lg:flex-auto">
                <!-- <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">We’re always looking for awesome people to join us</h2> -->
                <!-- <p class="mt-6 text-xl leading-8 text-gray-600">Diam nunc lacus lacus aliquam turpis enim. Eget hac velit est euismod lacus. Est non placerat nam arcu. Cras purus nibh cursus sit eu in id.</p> -->
                <!-- <img src="https://images.unsplash.com/photo-1606857521015-7f9fcf423740?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1344&h=1104&q=80" alt="" class="mt-4 aspect-[6/5] w-full bg-gray-50 object-cover lg:aspect-auto " />
                <div class="single-event_detail">
                    <event-follow :active="{{json_encode($event->isFollowedTo)}}"></event-follow>
                    <p class="text-justify">{!! $event->desc !!}</p>
                </div> -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <img src="https://images.unsplash.com/photo-1606857521015-7f9fcf423740?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1344&h=1104&q=80" alt="" class="w-full h-auto rounded-t-lg mb-4" />
                    <img src="{{$event->image_path}}" alt="" class="w-full h-auto rounded-t-lg mb-4">
                    <div class="mb-4">
                        <!-- Event Follow Button -->
                        <event-follow :active="{{json_encode($event->isFollowedTo)}}"></event-follow>
                        <p class="text-gray-700 text-justify mt-2">{!! $event->desc !!}</p>
                    </div>

                    <!-- Event Reply Form -->
                    @if(Auth::user() and $replies->count() > 0)
                    <!-- <reply-form :event="{{$event}}"></reply-form> -->
                     <discussion-modal :event="{{$event}}"></discussion-modal>
                    @endif

                    <h4 class="text-center mt-6 text-xl font-semibold">Discussions</h4>

                    <!-- All Event Discussions -->
                    @if($replies->count() > 0)
                    @foreach ($replies as $reply)

                    <disscuss-reply></disscuss-reply>
                    @include('event.allreplies')
                    @endforeach
                    @else
                    <div class="text-center mt-8">
                        <h2 class="text-2xl font-bold mb-4">No New Discussion Yet</h2>
                        @if(Auth::user())
                            <discussion-modal :event="{{$event}}"></discussion-modal>
                        @endif
                    </div>
                    @endif
                </div>

            </div>
            <div class="w-full lg:flex-auto">
                <h3 class="sr-only">Event Details</h3>
                <div class="single-event_right mb-3 text-left" id="show">
                    <div class="p-4">
                    <!-- Event Top Badges-->
                        <p>
                            @if($event->strtdt > \Carbon\Carbon::now()->toDateTimeString())
                            <span class="border border-green-600 rounded-full px-4 text-sm text-green-600 py-0.5 mr-1">{{$event->strtdt->diffforHumans()}}</span>
                            @else
                            <span class="border border-red-600 rounded-full px-4 text-sm text-red-600 py-0.5 mr-1">{{$event->strtdt->diffforHumans()}}</span>
                            @endif
                            @if(\Carbon\Carbon::now()->toDateTimeString() > $event->enddt)
                            <span></span> @else
                            @if($event->qty!=0)
                            <span class="border border-green-600 rounded-full px-4 text-sm text-green-600 py-0.5 mr-1">Tickets Available</span>
                            @else
                            <span class="border border-red-600 rounded-full px-4 text-sm text-red-600 py-0.5 mr-1">Tickets Not Available</span>
                            @endif
                            @endif
                            @if(\Carbon\Carbon::now()->toDateTimeString() > $event->enddt)
                            <span class="border border-red-600 rounded-full px-4 text-sm text-red-600 py-0.5 mr-1">
                                Event Closed
                            </span>
                            <span class="badge badge-danger">Event Closed</span>
                            @else
                            <span class="border border-green-600 rounded-full px-4 text-sm text-green-600 py-0.5 mr-1">
                                Event Open
                            </span>
                            @endif

                        </p>
                        <!-- Event Info-->
                        <p class="single-event_name text-left mt-3">{{$event->name}}</p>
                        <p class="single-event_price mt-3">Price: ${{$event->price}}</p>
                    </div>
                    <div class="mt-4 p-4">
                        <h5><b>Date and time</b></h5>
                        <p><i class="far fa-calendar-alt"></i> <b>{{$event->startdate}} to {{$event->enddate}}</b></p>
                        <p><i class="far fa-clock"></i> <b>{{$event->strttm}} - {{$event->endtm}} GMT + 1</b></p>
                        <p><i class="fas fa-map-marker-alt"></i><span><b> {{$event->location}}</b></span>
                        <!-- <span><a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"> <b>More Info</b> <i class="far fa-arrow-alt-circle-down"></i></a></span> -->
                        </p>
                        <accordion-button>
                            <template v-slot:title>
                                <div>
                                    <b>Venue Info</b>
                                    <!-- <i class="far fa-arrow-alt-circle-down"></i> -->
                                </div>
                            </template>
                            <template v-slot:content>
                                <div>
                                    <div class="card card-body">
                                        @if($event->venue!=null)
                                        <b>{{$event->venue}}</b>
                                        @else
                                        <b>Sorry! No more information available</b>
                                        @endif
                                    </div>
                                </div>
                            </template>
                        </accordion-button>

                        <!--Event Ticket Option-->
                        <div class="py-4 flex justify-between">
                            <!-- <div>
                                <button @click="showModal = true" class="px-4 py-2 bg-blue-500 text-white rounded">View Event Guests</button>
                                <base-modal :visible="showModal" @update:visible="showModal = $event" title="Participating Event Guests">
                                    <button class="btn btn-lg btn-link float-right" @click="$modal.hide('guestModal')">x</button>
                                    @if($guests->count()>0)
                                    <p class="small text-center"><b>{{$guests->count()}} guests are going to attend this event</b></p>
                                    <div class="row">
                                        @foreach($guests as $guest)
                                        <div class="col-md-3 text-center">
                                            <div class="guest">
                                                <a href="/profile/{{$guest->id}}" target="_blank">
                                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcREMyvRO0cuDTlEXwAwDVQE3szE6ezl7USqNL_n9D_5w8zRCGtk" alt="">
                                                    <p><b>{{$guest->name}}</b></p>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <h3 class="text-center mt-5 mb-3">
                                        No Event Participating guest yet
                                    </h3>
                                    @endif
                                </base-modal>
                            </div> -->
                            <event-guests></event-guests>

                            <div>
                                @if(\Carbon\Carbon::now()->toDateTimeString() > $event->enddt)
                                <p></p>
                                @else
                                @if(Auth::user())
                                <ticket-form :event="{{$event}}"></ticket-form>
                                @else
                                <p><a href="/login" class="px-4 py-2 bg-blue-500 text-white rounded">Buy Ticket</a></p>
                                @endif
                                @endif
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Event Organizer -->
                <div class="px-4 text-left mt-4 single-event_organize">
                    <h5><b>Organizer</b></h5>
                    <p><a href="/profile/{{$event->user->id}}" target="_blank"><span><img src="{{$event->user->avatar_path}}" alt=""></span><span> <b>{{$event->user->name}}</b></span></a>
                    @if(Auth::user())
                    <span class="float-right">
                    <contact-form :event="{{$event}}"></contact-form>
                    </span>
                    @endif
                    </p>
                </div>
                <div id="map"></div>
                <!-- Event Add to calender-->
                <div title="Add to Calendar" class="addeventatc mt-3">
                    Add to Calendar
                    <span class="start">{{$event->eventstart}} {{$event->strttm}}</span>
                    <span class="end">{{$event->eventend}} {{$event->endtm}}</span>
                    <span class="timezone">Nigeria/Lagos</span>
                    <span class="title">{{$event->name}}</span>
                    <span class="description">{{$event->desc}}</span>
                    <span class="location">{{$event->location}}</span>
                </div>
                <div class="sharethis-inline-share-buttons mt-3"></div>
            </div>

            <!-- </div> -->
        </div>
    </div>

    <div class="topic-events mt-5 p-4 bg-gray-50 rounded-lg shadow-md">
        <!-- Related Events Title -->
        <h3 class="text-2xl font-semibold text-gray-800 mb-5 text-center">Related Events</h3>

        <!-- Check if there are no related events -->
        @if($related_events->count() == 0)
        <h3 class="text-center text-gray-500">No Related Event Exists</h3>
        @else
        <!-- Related Events Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($related_events as $event)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <a href="{{$event->path()}}" class="block">
                    <!-- Event Image -->
                    <div class="relative">
                        <img src="{{$event->image_path}}" alt="Event Image" class="w-full h-48 object-cover">
                        <!-- Optional: Overlay effect on image -->
                        <!-- <div class="absolute inset-0 bg-black opacity-25"></div> -->
                    </div>
                    <!-- Event Details -->
                    <div class="p-4">
                        <!-- Event Time -->
                        <div class="flex items-center text-gray-600 mb-2 text-sm">
                            <i class="far fa-clock mr-2"></i>
                            <span>{{$event->startdate}},</span>
                            <span>{{$event->strttm}}</span>
                        </div>
                        <!-- Event Name -->
                        <p class="text-lg font-semibold text-gray-800 truncate">{{$event->name}}</p>
                        <!-- Event Location -->
                        <p class="text-gray-500 mt-1">{{$event->location}}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>

@include('footer')
