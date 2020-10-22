<?php

// This controller controls all the logics regarding the user's personal information

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Submission;
use App\Models\Talks;
use App\Models\UserInfo;
use App\Models\UserSign;

class InfoController extends Controller
{
    // retrieve user's information statically
    public static function getUserInfoFromView($uid)
    {
        $user = UserInfo::where('uid', '=', $uid)->first();
        if (!$user) return false;
        return $user;
    }


    // myaccount page, assumed user is signed in, this was checked by middleware checksigned
    public function myaccount($uid)
    {
        // 1. is $uid passed a signed in account
        if (!session()->get('user') || session()->get('user')->uid != $uid)
            $is_signed = false;
        else $is_signed = true;
        // 2. here invoke userinfo again is because our session doesn't change once after signing in,
        // so whenever user's information changes, we need to capture it
        $user = UserSign::where('uid', $uid)->first();
        $user_info = UserInfo::where('uid', $uid)->first();

        // 3. user doesn't exist
        if (!$user || !$user_info) return redirect('/public/index');

        // 4. pass user's submission
        $submission = Submission::where([
            ['uid', '=', $uid]
        ])->orderBy('sid', 'desc')->limit(30)->simplePaginate(10);

        // 5. get user's most recent 10 comments
        $numcomments = 10;
        $comments = Comments::where('uid', $uid)->orderBy('cid', 'desc')->limit($numcomments)->get();

        // 6. get user's most recent 10 talks
        $numtalks = 10;
        $talks = Talks::where('uid',$uid)->orderBy('tid','desc')->limit($numtalks)->get();

        // 5. success and redirect
        return view('myaccount', compact('user', 'user_info', 'is_signed', 'submission', 'comments','talks'));
    }
}
