<?php

namespace App\Http\Controllers;

use App\Models\Replies;
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

    // function that returns a edit talk page view
    public function edittalkpage($tid){
        // 1. check if talk exists
        $talk = Talks::where('tid',$tid)->first();
        if(!$talk) return redirect('/public/talks');

        // 2. check if this user is the author of the given $tid
        if(session()->get('user')->uid != $talk->uid)
            return redirect('/public/talks');

        // 3. get the original information from the database
        $oldtid = $tid;
        $oldttit = $talk->ttit;
        $oldtopicname= $talk->topic->topicname;
        $oldtcontent = $talk->tcontent;

        // 4. return to view
        return view('createtalk',compact('oldtid','oldttit','oldtopicname','oldtcontent'));
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
        $topicSelector = Topics::where('topicname','=',ucfirst(strtolower(trim($request->input('maintopic')))));
        $topicId = -1;
        if($topicSelector->exists()){
            $topicId = $topicSelector->first()->topicid;
        }
        else{
            $topic = Topics::create([
                'topicname' => ucfirst(strtolower(trim($request->input('maintopic')))),
                'uid' => session()->get('user')->uid,
                'topicbelongsto' => 0,
                'topiccolor' => rand(0,150).','.rand(0,150).','.rand(0,150)
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
        if($talk) return redirect('/public/getsingletalk/'.$talk->tid)->with('success-msg','Congratulations, you successfully posted a talk!'); // return to the talk page
        return redirect('/protected/createtalk')->withErrors('Sorry, we cannot process your request at this moment, please try again!');
    }


    // function that handle the update request
    public function handleedittalk(Request $request){
        // 1. validate information and sanity check
        $this->validate($request,[
            'talktitle' => 'required|min:5|max:50|regex:/^[A-Za-z0-9\s]{5,50}$/',
            'maintopic' => 'required|min:2|max:20|regex:/^[\w]*$/',
            'content' => 'required|min:20|max:20000',
            'oldtid' => 'required|integer'
        ]);

        // 2. find the original talk
        $titles = Talks::where('ttit',trim($request->input('talktitle')))->get('tid');
        $oldtalk = Talks::where('tid',$request->input('oldtid'))->first();
        if(!$oldtalk) return redirect('/protected/createtalk');
        if($oldtalk->ttit != trim($request->input('talktitle')) && count($titles) > 0)
            return redirect('/protected/edittalk/'.$oldtalk->tid)->withErrors('Sorry, the title has been taken!');

        // 3. topic changes
        $oldtopicname = $oldtalk->topic->topicname;
        $inputtopicname = ucfirst(strtolower(trim($request->input('maintopic'))));
        // if topic is the same
        if($inputtopicname == $oldtopicname){
            if($oldtalk->ttit == trim($request->input('talktitle')) && $oldtalk->tcontent == trim($request->input('content')))
                return redirect('/protected/edittalk/'.$oldtalk->tid)->withErrors('Sorry, you did not make any changes to your talk!');
            $topicId = Topics::where('topicname',$oldtopicname)->first()->topicid;
        }
        else{
            // change the original topic usages
            $topicId = Topics::where('topicname',$oldtopicname)->first()->decrement('topicbelongsto');
            // check if the topic exists, if so, use that one, if not, create a new one
            $topicSelector = Topics::where('topicname','=',$inputtopicname);
            if($topicSelector->exists()){
                $topicId = $topicSelector->first()->topicid;
            }
            else{
                $topic = Topics::create([
                    'topicname' => ucfirst(strtolower(trim($request->input('maintopic')))),
                    'uid' => session()->get('user')->uid,
                    'topicbelongsto' => 0,
                    'topiccolor' => rand(0,150).','.rand(0,150).','.rand(0,150)
                ]);
                $topicId = $topic->topicid;
            }
            Topics::where('topicid','=',$topicId)->increment('topicbelongsto');
        }

        // 4. update the database
        $affected = Talks::where('tid',$oldtalk->tid)->update([
            'ttit' => trim($request->input('talktitle')),
            'topicid' => $topicId,
            'tcontent' => trim($request->input('content'))
        ]);

        // 5. redirect
        if($affected == 1) return redirect('/public/getsingletalk/'.$oldtalk->tid)->with('success-msg','Congratulations, you successfully edited your talk!'); // return to the talk page
        return redirect('/protected/edittalk/'.$request->input('oldtid'))->withErrors('Sorry, we cannot process your request at this moment, please try again!');
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


        if(count($res) > 0){
            $data = "";
            foreach($res as $talk){
                $data .= '<a href="'.url('/public/getsingletalk/'.$talk->tid).'" style="color: #0779e4; font-weight: bold">'.
                    $talk->ttit.
                    '</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span style="color:darkgray">By</span>&nbsp;&nbsp;&nbsp;
                    <a href="'.url('/public/myaccount/'.$talk->uid).'">'.
                    $talk->user->user->username.
                    '</a><br><br>';
            }
            return ['status'=>1, 'data' => $data];
        }
        else
            return ['status'=>-1, 'data'=>'No Result'];
    }


    // getsingle talk view
    function getsingletalk($tid){
        $talk = Talks::where('tid',$tid)->first();
        if(!$talk) return redirect('/public/talks');
        // add talk's view count
        $talk->tviews++;
        $talk->timestamps = false;
        $talk->save();

        // get replies
        $replies = Replies::where('tid', $tid)->orderBy('created_at', 'desc')->simplePaginate(20);
        $replies_size = count(Replies::where('tid', $tid)->get('rid'));
        return view('getsingletalk',compact('talk','replies','replies_size'));
    }


    // choosing topics
    function choosetopics($tids=null){
        $populartopics = Topics::orderBy("topicbelongsto","desc")->limit(30)->get();
        $newtopics = Topics::orderBy("topicId","desc")->limit(30)->get();
        if(!$tids) return view('choosetopics',compact('populartopics','newtopics'));

        $tidsarray = array_unique(explode('&',$tids));

        $talks = Talks::whereIn("topicid",$tidsarray)->orderBy("tviews","desc")->limit(50)->get();
        $selectedtopics = Topics::whereIn("topicid",$tidsarray)->get();

        return view('choosetopics',compact('populartopics','newtopics',"talks","selectedtopics"));

    }



}
