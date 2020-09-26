<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\User;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    // ranking page, sort the user by total acceptance and acceptance rate
    public function rankingpage(){
        $users = UserInfo::orderBy('userac','desc')->
                 orderBy('usersubmission','asc')->
                 orderBy('userprivil','desc')->
                 simplePaginate(50);
        return view('ranking',compact('users'));
    }
}
