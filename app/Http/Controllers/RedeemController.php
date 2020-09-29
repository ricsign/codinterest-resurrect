<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;

class RedeemController extends Controller
{
    public function redeempage(){
        return view('redeem');
    }

    // item 1: key, 2: 10 keys, 3: silver coder, 4: gold coder + 5 keys, 5: red coder + 50 keys
    public function redeemitem($item){
        // prices
        $keycost = 10;
        $tenkeyscost = 90;
        $silvercost = 1000;
        $goldcost = 2000;
        $redcost = 4500;

        // 1. retrieve user's information
        $uid = session()->get('user')->uid;
        $user = UserInfo::where('uid',$uid)->first();
        $usercoins = intval($user->usercoins);
        $userprivil = $user->userprivil;
        $userkeys = $user->userkeys;

        // 2. redeem items
        switch ($item) {
            // key
            case 1:
                if ($usercoins >= $keycost) {
                    $res = $user->update([
                        'usercoins' => $usercoins - $keycost,
                        'userkeys' => $userkeys + 1
                    ]);
                    if ($res) return redirect('/public/redeem')->with(
                        'successmsg',
                        'Congratulations, you have successfully redeemed 1 X Key,
                         your current balance is ' . ($usercoins-$keycost) . ' coins'
                    );
                    else return redirect('/public/redeem')->with('errormsg', 'Sorry, there is an error occured. Please try again later');
                } else return redirect('/public/redeem')->with('errormsg', 'Sorry, you are not qualified or your balance is not enough to redeem this item.');
                break;
            // 10 keys
            case 2:
                if ($usercoins >= $tenkeyscost) {
                    $res = $user->update([
                        'usercoins' => $usercoins - $tenkeyscost,
                        'userkeys' => $userkeys + 10
                    ]);
                    if ($res) return redirect('/public/redeem')->with(
                        'successmsg',
                        'Congratulations, you have successfully redeemed 10 X Key,
                         your current balance is ' . ($usercoins - $tenkeyscost) . ' coins'
                    );
                    else return redirect('/public/redeem')->with('errormsg', 'Sorry, there is an error occured. Please try again later');
                } else return redirect('/public/redeem')->with('errormsg', 'Sorry, you are not qualified or your balance is not enough to redeem this item.');
                break;
            // silver coder
            case 3:
                if ($usercoins >= $silvercost && $userprivil == 0) {
                    $res = $user->update([
                        'usercoins' => $usercoins - $silvercost,
                        'userprivil' => 1
                    ]);
                    if ($res) return redirect('/public/redeem')->with(
                        'successmsg',
                        'Congratulations, you have successfully became a Silver Coder,
                         you are now having the privileges of a Silver Coder.
                         Your current balance is ' . ($usercoins - $silvercost) . ' coins'
                    );
                    else return redirect('/public/redeem')->with('errormsg', 'Sorry, there is an error occured. Please try again later');
                } else return redirect('/public/redeem')->with('errormsg', 'Sorry, you are not qualified or your balance is not enough to redeem this item.');
                break;
            // gold coder
            case 4:
                if ($usercoins >= $goldcost && $userprivil == 1) {
                    $res = $user->update([
                        'usercoins' => $usercoins - $goldcost,
                        'userprivil' => 2,
                        'userkeys' => $userkeys + 5
                    ]);
                    if ($res) return redirect('/public/redeem')->with(
                        'successmsg',
                        'Congratulations, you have successfully became a Gold Coder and earned 5 keys,
                         you are now having the privileges of a Gold Coder.
                         Your current balance is ' . ($usercoins - $goldcost) . ' coins'
                    );
                    else return redirect('/public/redeem')->with('errormsg', 'Sorry, there is an error occured. Please try again later');
                } else return redirect('/public/redeem')->with('errormsg', 'Sorry, you are not qualified or your balance is not enough to redeem this item.');
                break;
            // red coder
            case 5:
                if ($usercoins >= $redcost && $userprivil == 2) {
                    $res = $user->update([
                        'usercoins' => $usercoins - $redcost,
                        'userprivil' => 3,
                        'userkeys' => $userkeys + 50
                    ]);
                    if ($res) return redirect('/public/redeem')->with(
                        'successmsg',
                        'Congratulations, you have successfully became a Red Coder and earned 50 keys,
                         You are now having the privileges of a Red Coder.
                         your current balance is ' . ($usercoins - $redcost) . ' coins'
                    );
                    else return redirect('/public/redeem')->with('errormsg', 'Sorry, there is an error occured. Please try again later');
                } else return redirect('/public/redeem')->with('errormsg', 'Sorry, you are not qualified or your balance is not enough to redeem this item.');
                break;
            default:
                return redirect('/public/redeem')->with('errormsg', 'Sorry, there is an error occured. Please try again later');
        }
    }
}
