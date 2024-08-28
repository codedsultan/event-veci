<?php

namespace App\Http\Controllers;

use App\Models\DiscussionReply;
use App\Models\Reply;
use Auth;
use Illuminate\Http\Request;

class DiscussionReplyController extends Controller
{
    public function store(Reply $reply, Request $request)
    {
        $this->validate($request, [
            'replybody'=>'required',
        ]);
        $reply->addDiscussionReply([
            'replybody'=>request('replybody'),
            'user_id'=> $request()->user()->id()
        ]);
    }

    public function update(DiscussionReply $discussionreply, Request $request)
    {
        $this->validate($request, [
            'replybody'=>'required',
        ]);
        $this->authorize('permission', $discussionreply);
        $discussionreply->update(request(['replybody']));
    }

    public function destroy(DiscussionReply $discussionreply)
    {
        $this->authorize('permission', $discussionreply);
        $discussionreply->delete();
        if (request()->wantsJson()) {
            return response(['status'=>'Discussion Reply deleted']);
        }

        return back();
    }
}
