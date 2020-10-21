<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Comments;
use App\Models\Talks;
use App\Models\Replies;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function postcomment(Request $request)
    {

        // 1. validate user's data
        $this->validate($request, [
            'aid' => 'exists:App\Models\Articles,aid',
            'compose-textarea' => 'required|min:5|max:2000',
        ]);

        // 2. add comment
        Articles::where('aid', $request->input('aid'))->first()->increment('acomments');

        $res = Comments::create([
            'uid' => session()->get('user')->uid,
            'aid' => $request->input('aid'),
            'ccontent' => $request->input('compose-textarea'),
        ]);

        if (!$res) return redirect('/public/getsinglearticle/' . $request->input('aid') . '#compose-h3')->withErrors('Internal Errors just occurred, please try again later!');
        return redirect('/public/getsinglearticle/' . $request->input('aid') . '#compose-h3')->with('comment-success', 'You successfully posted a comment!');
    }


    public function deletecomment($cid)
    {
        // 1. check if comment exists
        $comment = Comments::where('cid', $cid)->first();
        if (!$comment)
            return redirect('/public/allarticles');
        // 2. check if this user posted this comment
        if (session()->get('user')->uid != $comment->uid)
            return redirect('/public/allarticles');
        // 3. delete the comment and redirect
        if (Comments::where('cid', $cid)->delete()) {
            Articles::where('aid', $comment->aid)->first()->decrement('acomments');
            return redirect('/public/getsinglearticle/' . $comment->aid . '#compose-h3')->with('comment-success', 'You successfully deleted a comment!');
        } else
            return redirect('/public/getsinglearticle/' . $comment->aid . '#compose-h3')->withErrors('Sorry, we could not delete your comment at this moment!');

    }


    public function postreply(Request $request)
    {

        // 1. validate user's data
        $this->validate($request, [
            'tid' => 'exists:App\Models\Talks,tid',
            'compose-textarea' => 'required|min:5|max:2000',
        ]);

        // 2. add reply
        Talks::where('tid', $request->input('tid'))->first()->increment('treplies');

        $res = Replies::create([
            'uid' => session()->get('user')->uid,
            'tid' => $request->input('tid'),
            'rcontent' => $request->input('compose-textarea'),
        ]);

        if (!$res) return redirect('/public/getsingletalk/' . $request->input('tid') . '#compose-h3')->withErrors('Internal Errors just occurred, please try again later!');
        return redirect('/public/getsingletalk/' . $request->input('tid') . '#compose-h3')->with('reply-success', 'You successfully posted a reply!');
    }


    public function deletereply($rid)
    {
        // 1. check if reply exists
        $reply = Replies::where('rid', $rid)->first();
        if (!$reply)
            return redirect('/public/talks');
        // 2. check if this user posted this comment
        if (session()->get('user')->uid != $reply->uid)
            return redirect('/public/allarticles');
        // 3. delete the comment and redirect
        if (Replies::where('rid', $rid)->delete()) {
            Talks::where('tid', $reply->tid)->first()->decrement('treplies');
            return redirect('/public/getsingletalk/' . $reply->tid . '#compose-h3')->with('reply-success', 'You successfully deleted a reply!');
        } else
            return redirect('/public/getsingletalk/' . $reply->tid . '#compose-h3')->withErrors('Sorry, we could not delete your reply at this moment!');

    }
}
