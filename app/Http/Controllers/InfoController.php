<?php

namespace App\Http\Controllers;

use App\Models\Problems;
use App\Models\Submission;
use App\Models\UserInfo;
use App\Models\UserSign;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    // assumed user is signed in, this was checked by middleware checksigned
    public function myaccount($uid){
        // 1. is $uid passed a signed in account
        if(!session()->get('user') || session()->get('user')->uid != $uid)
            $is_signed = false;
        else $is_signed = true;
        // 2. here invoke userinfo again is because our session doesn't change once after signing in,
        // so whenever user's information changes, we need to capture it
        $user = UserSign::where('uid',$uid)->first();
        $user_info = UserInfo::where('uid',$uid)->first();

        // 3. user doesn't exist
        if(!$user || !$user_info) return redirect('/public/index');

        // 4. pass user's submission
        $submission = Submission::where([
            ['uid','=',$uid]
        ])->orderBy('sid','desc')->limit(30)->simplePaginate(10);

        // 5. success and redirect
        return view('myaccount',compact('user','user_info','is_signed','submission'));
    }
}
