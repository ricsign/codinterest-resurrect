<?php

namespace App\Http\Controllers;

use App\Models\Problems;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProblemsController extends Controller{
    // get all attempted problems (not necessarily wrong), no route will be connected to this
    public static function getattempted(){
        $attempted = array();
        if(session()->get('user')){
            $attempted_raw = Submission::where([
                ['uid','=',session()->get('user')->uid],
            ])->get('pid')->toArray();

            // convert raw array
            for ($i=0;$i<count($attempted_raw);$i++)
                array_push($attempted,$attempted_raw[$i]['pid']);
        }
        return array_unique($attempted);
    }

    // get all accepted problems, no route will be connected to this
    public static function getsolved(){
        $solved = array();
        if(session()->get('user')){
            $solved_raw = Submission::where([
                ['uid','=',session()->get('user')->uid],
                ['status','=',1]
            ])->get()->toArray();

            // convert raw array
            for ($i=0;$i<count($solved_raw);$i++)
                array_push($solved,$solved_raw[$i]['pid']);
        }
        return array_unique($solved);
    }

    // all problems page
    public function allproblems(){
        // every page contains 30 problems
        $problems = Problems::simplePaginate(30);
        $solved = $this->getsolved();
        $attempted = $this->getattempted();
        return view('allproblems',compact('problems','solved','attempted'));
    }

    // all problems page(from a view)
    public static function allproblemsFromView(){
        return Problems::all();
    }

    // getproblems page
    public function getproblems($pterrid){
        $problems = Problems::where('pterrid',$pterrid)->get();
        $solved = $this->getsolved();
        $attempted = $this->getattempted();
        return view('getproblems',compact('problems','solved','attempted'));
    }

    // get single problem page
    public function getsingleproblem($pid){
        $problem = Problems::get()->where('pid',$pid)->first();
        if(!$problem) return redirect('/public/allproblems');

        // check if user is already accepted on this single problem
        $is_ac = false;
        if(session()->get('user')){
            $ac = Submission::where([
                ['pid','=',$pid],
                ['uid','=',session()->get('user')->uid],
                ['status','=',1]
            ])->first();
            if($ac) $is_ac = true;
        }
        return view('getsingleproblem',compact('problem','is_ac'));
    }

    public function solution($pid){
        $uid = session()->get('user')->uid;
        // check if user is accepted
        if(!Submission::where([['uid','=',$uid], ['pid','=',$pid], ['status','=',1]])->first())
            return redirect('/public/allproblems');

        $problem = Problems::where('pid',$pid)->first();
        if(!$problem) return redirect('/public/allproblems');
        return view('solution',compact('problem'));
    }

}
