<?php

// This controller controls all the logics regarding the ranking

namespace App\Http\Controllers;

use App\Models\UserInfo;

class RankingController extends Controller
{
    // ranking page, sort the user by total acceptance and acceptance rate
    public function rankingpage()
    {
        $users = UserInfo::where('userprivil', '<>', -1)->
        orderBy('userac', 'desc')->
        orderBy('usersubmission', 'asc')->
        orderBy('userprivil', 'desc')->
        simplePaginate(100);
        return view('ranking', compact('users'));
    }
}
