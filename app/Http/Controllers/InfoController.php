<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\Models\UserSign;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    // assumed user is signed in, this was checked by middleware checksigned
    public function myaccount($uid){
        // is $uid passed a signed in account
        if(!session()->get('user') || session()->get('user')->uid != $uid)
            $is_signed = false;
        else $is_signed = true;
        // here invoke userinfo again is because our session doesn't change once after signing in,
        // so whenever user's information changes, we need to capture it
        $user = UserSign::where('uid',$uid)->first();
        $user_info = UserInfo::where('uid',$uid)->first();

        // user doesn't exist
        if(!$user || !$user_info) return redirect('/public/index');
        // user exist
        return view('myaccount',compact('user','user_info','is_signed'));
    }
}
