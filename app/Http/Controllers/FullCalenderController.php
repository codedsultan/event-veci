<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;

class FullCalenderController extends Controller
{
    public function view()
    {
        $eventss = Event::orderBy('created_at', 'desc')->paginate(8);
        // $calenderevents = Event::get();
        // $event_list = [];
        // foreach ($calenderevents as $key=>$event) {
        //     $event_list[] = Calendar::event(
        //    $event->name,
        //     true,
        //     new \DateTime($event->strtdt),
        //     new \DateTime($event->enddt.'+1 day'),
        //       0, [
        //           'url' => "events/$event->slug"
        //       ]
        //    );
        // }
        // $eloquentEvent = Event::first();
        // $calender_details = Calendar::addEvents($event_list);
        foreach ($eventss as $event) {
            // dd($event->strtdt->toDateString());
            // dd(Carbon::parse($event->strtdt->toDateString().' '. $event->strttm));
            $events[] = [
                'title' => $event->name,
                'start' => $event->strtdt->toDateString().' '. $event->strttm.':00',
                'end'=> $event->enddt->toDateString().' '. $event->endtm.':00',
                // 'start' => new \DateTime($event->strtdt->toDateString().' '. $event->strttm),
                // 'end'=> new \DateTime($event->enddt->toDateString().' '. $event->endtm),
                // $event->created_at,//new \DateTime($event->strtdt),
            //    new \DateTime($event->strtdt)
                // 'end' => $event->updated_at,// \DateTime($event->enddt.'+1 day'),
            ];
        }
        // dd($events);

        return view('event.calender', compact('events'));
    }
}
