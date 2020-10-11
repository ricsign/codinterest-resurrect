<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Comments;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function postcomment(Request $request){

        // 1. validate user's data
        $this->validate($request,[
            'aid' => 'exists:App\Models\Articles,aid',
            'compose-textarea' => 'required|min:5|max:2000',
        ]);

        // 2. add comment
        Articles::where('aid',$request->input('aid'))->first()->increment('acomments');

        $res = Comments::create([
            'uid' => session()->get('user')->uid,
            'aid' => $request->input('aid'),
            'ccontent' => $request->input('compose-textarea'),
        ]);

        if(!$res) return redirect('/public/getsinglearticle/'.$request->input('aid').'#compose-h3')->withErrors('Internal Errors just occurred, please try again later!');
        return redirect('/public/getsinglearticle/'.$request->input('aid').'#compose-h3')->with('comment-success','You successfully posted a comment!');
    }


    public function deletecomment($cid){
        // 1. check if comment exists
        $comment = Comments::where('cid',$cid)->first();
        if(!$comment)
            return redirect('/public/allarticles');
        // 2. check if this user posted this comment
        if(session()->get('user')->uid != $comment->uid)
            return redirect('/public/allarticles');
        // 3. delete the comment and redirect
        if(Comments::where('cid',$cid)->delete()){
            Articles::where('aid',$comment->aid)->first()->decrement('acomments');
            return redirect('/public/getsinglearticle/'.$comment->aid.'#compose-h3')->with('comment-success','You successfully deleted a comment!');
        }
        else
            return redirect('/public/getsinglearticle/'.$comment->aid.'#compose-h3')->withErrors('Sorry, we could not delete your comment at this moment!');

    }
}
