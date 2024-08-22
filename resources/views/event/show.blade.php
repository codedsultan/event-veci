@include('header')
<script src="https://checkout.stripe.com/checkout.js"></script>
@include('event.map')
<div id="app" class="mx-auto max-w-7xl">
<div class="mx-auto mt-12 max-w-7xl px-6 lg:px-16">
        <div class="mx-auto flex max-w-2xl flex-col  justify-between gap-16 lg:mx-auto lg:max-w-7xl lg:flex-row">
          <div class="w-full lg:max-w-xl lg:flex-auto">
            <!-- <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">We’re always looking for awesome people to join us</h2> -->
            <!-- <p class="mt-6 text-xl leading-8 text-gray-600">Diam nunc lacus lacus aliquam turpis enim. Eget hac velit est euismod lacus. Est non placerat nam arcu. Cras purus nibh cursus sit eu in id.</p> -->
            <img src="https://images.unsplash.com/photo-1606857521015-7f9fcf423740?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1344&h=1104&q=80" alt="" class="mt-4 aspect-[6/5] w-full bg-gray-50 object-cover lg:aspect-auto " />
            <div class="single-event_detail">
                <!--Event Follow Button-->
                <event-follow :active="{{json_encode($event->isFollowedTo)}}"></event-follow>
                <p class="text-justify">{!! $event->desc !!}</p>
            </div>
          </div>
          <div class="w-full lg:max-w-xl lg:flex-auto">
            <h3 class="sr-only">Event Details</h3>
            <div class="single-event_right mb-3 text-left" id="show">
                    <div class="p-4">
                       <!-- Event Top Badges-->
                        <p>
                            @if($event->strtdt > \Carbon\Carbon::now()->toDateTimeString())
                            <span class="border border-green-600 rounded-full px-4 text-sm text-green-600 py-0.5">{{$event->strtdt->diffforHumans()}}</span>
                            @else
                            <span class="border border-red-600 rounded-full px-4 text-sm text-red-600 py-0.5">{{$event->strtdt->diffforHumans()}}</span>
                            @endif
                            @if(\Carbon\Carbon::now()->toDateTimeString() > $event->enddt)
                            <span></span> @else
                             @if($event->qty!=0)
                            <span class="border border-green-600 rounded-full px-4 text-sm text-green-600 py-0.5">Tickets Available</span>
                            @else
                            <span class="border border-red-600 rounded-full px-4 text-sm text-red-600 py-0.5">Tickets Not Available</span>
                             @endif
                             @endif
                            @if(\Carbon\Carbon::now()->toDateTimeString() > $event->enddt)
                            <span class="border border-red-600 rounded-full px-4 text-sm text-red-600 py-0.5">
                                Event Closed
                            </span>
                            <span class="badge badge-danger">Event Closed</span>
                            @else
                            <span class="border border-green-600 rounded-full px-4 text-sm text-green-600 py-0.5">
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
            <div class="mt-8 flex border-t border-gray-100 pt-8">
              <!-- <a href="#" class="text-sm font-semibold leading-6 text-indigo-600 hover:text-indigo-500">View all openings <span aria-hidden="true">&rarr;</span></a> -->
            </div>
          </div>
        </div>
    </div>

    <div class="topic-events mt-5">

        <!-- Related Events-->
        <h3 class="text-cente mb-5">Related Events</h3>
        <div class="row">
           @if($related_events->count() == 0)
           <h3 class="text-center">No Related Event Exist</h3>
           @endif
            @foreach($related_events as $event)
            <div class="col-md-3 text-center">
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
            </div>
            @endforeach
        </div>
    </div>
</div>

