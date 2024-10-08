<?php

namespace App\Http\Controllers;

use App\Http\FormRequests\CreateEventForm;
use App\Models\Event;
use App\Models\Reply;
use Auth;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    }

    public function store(Request $request, Event $event, CreateEventForm $form)
    {
        $this->validate($request, [
            'body'=>'required|spamerror',
        ]);
        $event->addReply([
            'body'=>request('body'),
            'user_id'=> $request()->user()->id()
        ]);

        if (request()->wantsJson()) {
            return ['message'=>$event->path()];
        }

        return back();
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $this->validate(request(), ['body'=>'required|spamerror']);
        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();
        if (request()->wantsJson()) {
            return response(['status'=>'Reply deleted']);
        }

        return back();
    }
}
