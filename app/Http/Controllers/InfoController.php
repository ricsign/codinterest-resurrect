<?php

// This controller controls all the logics regarding the user's personal information

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Submission;
use App\Models\Talks;
use App\Models\UserInfo;
use App\Models\UserSign;
use Illuminate\Http\Request;

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

        // 7. success and redirect
        return view('myaccount', compact('user', 'user_info', 'is_signed', 'submission', 'comments','talks'));
    }


    // save user's personal description logic
    public function saveuserdesc(Request $request){
        // 1. validate
        if(mb_strlen($request->input('userdesc')) > 1000 || mb_strlen($request->input('userdesc')) < 20)
            return ['status' => -1, 'msg' => 'Please enter at least 20 characters and at most 1000 characters!'];

        // 2. find user
        $user = UserInfo::where('uid', $request->input('uid'))->first();
        if(!$user) return ['status' => -1, 'msg' => 'Sorry, we could not update your information right now, please try again later!'];

        // 3. update
        $res = $user->update([
            'userdesc' => $request->input('userdesc')
        ]);

        // 4. redirect
        if($res)
            return ['status' => 1, 'msg' => 'You successfully updated your personal information!'];
        return ['status' => -1, 'msg' => 'Sorry, you did not change your information!'];
    }
}
