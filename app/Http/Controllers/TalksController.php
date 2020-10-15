<?php

namespace App\Http\Controllers;

use App\Models\Talks;
use App\Models\Topics;
use Illuminate\Http\Request;

class TalksController extends Controller
{
    // function that return all talks page
    public function talks(){
        $talksPopular = Talks::orderBy('tviews','desc')
            ->orderBy('treplies','desc')
            ->simplePaginate(30);
        $talksRecent = Talks::orderBy('tid','desc')->simplePaginate(30);
        $talksMostReplies = Talks::orderBy('treplies','desc')->orderBy('tviews','desc')->simplePaginate(30);
        $talksLatestUpdate = Talks::orderBy('updated_at','desc')->simplePaginate(30);

        return view('talks',compact('talksRecent','talksPopular','talksMostReplies','talksLatestUpdate'));
    }

    // function that returns a create talk page view
    public function createtalkpage(){
        return view('createtalk');
    }


    // function that upload a new talk to the database
    public function newtalk(Request $request){

        // 1. validate information and sanity check
        $this->validate($request,[
            'talktitle' => 'required|min:5|max:50|regex:/^[A-Za-z0-9\s]{5,50}$/|unique:talks,ttit',
            'maintopic' => 'required|min:2|max:20|regex:/^[\w]*$/',
            'content' => 'required|min:20|max:20000'
        ]);

        // 2. check if the topic exists, if so, use that one, if not, create a new one
        $topicSelector = Topics::where('topicname','=',$request->input('maintopic'));
        $topicId = -1;
        if($topicSelector->exists()){
            $topicId = $topicSelector->first()->topicid;
        }
        else{
            $topic = Topics::create([
                'topicname' => ucfirst(strtolower(trim($request->input('maintopic')))),
                'uid' => session()->get('user')->uid,
                'topicbelongsto' => 0
            ]);
            $topicId = $topic->topicid;
        }

        // 3. upload talk to the database
        Topics::where('topicid','=',$topicId)->increment('topicbelongsto');
        $talk = Talks::create([
            'uid' => session()->get('user')->uid,
            'ttit' => trim($request->input('talktitle')),
            'topicid' => $topicId,
            'tcontent' => trim($request->input('content')),
            'tviews' => 0,
            'treplies' => 0
        ]);

        // 4. redirect
        if($talk) return redirect('/public/index'); // return to the talk page, change it later
        return redirect('/protected/createtalk')->withErrors('Sorry, we cannot process your request at this moment, please try again!');
    }


    // function that search for topic
    public function topicsearchresult(Request $request){
        // 1. validate information and sanity check
        if(!preg_match('/^[A-Za-z0-9\s]{1,50}$/',$request->input('userInput'))){
            return ['status'=>-1, 'data'=>'No Result'];
        }
        // 2. retrieve topics from database
        $allpossibletopicids = array();
        $res = array();
        $topics = Topics::where('topicname','LIKE',"%".$request->input('userInput')."%")->get();
        foreach ($topics as $topic){
            $allpossibletopicids []= $topic->topicid;
        }

        // 3. retrieve talks from database
        foreach ($allpossibletopicids as $topicid){
            foreach(Talks::where('topicid',$topicid)->get() as $talk){
                $res []= $talk;
            }
        }

        if(count($res) > 0)
            return ['status'=>1, 'data'=>$res];
        else
            return ['status'=>-1, 'data'=>'No Result'];
    }
}
