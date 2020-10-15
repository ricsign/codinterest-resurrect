<?php

namespace App\Http\Controllers;

use App\Models\Problems;
use App\Models\Submission;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    // skip a problem
    public function skip($pid)
    {
        // 1. retrieve information
        $uid = session()->get('user')->uid;
        $user = UserInfo::where('uid', $uid)->first();

        // 2. see if qualified: -does problem exist? -does user have enough key? -is problem accepted?
        $problem = Problems::where('pid', $pid)->first();
        if (!$problem) return redirect('/public/allproblems');

        $ac = Submission::where([
            ['uid', '=', $uid],
            ['pid', '=', $pid],
            ['status', '=', 1]
        ])->first();
        if ($ac) return redirect('/public/getsingleproblem/' . $pid)->withErrors('Your are already accepted!');

        $userkeys = UserInfo::where('uid', $uid)->first()->userkeys;
        if ($userkeys < 1) return redirect('/public/getsingleproblem/' . $pid)->withErrors('Your keys are not enough!');

        // 3. update user info and submission and problem total ac
        // update problem total submission and acceptance
        $problem->increment('psub');
        $problem->increment('pacc');
        // update submission record
        Submission::create([
            'uid' => $uid,
            'pid' => $pid,
            'status' => 1
        ]);
        // update user information
        $user->decrement('userkeys');
        $user->increment('usersubmission');
        $user->increment('userac');

        return redirect('/public/getsingleproblem/' . $pid);
    }

    // processing submission
    public function submission(Request $request)
    {
        //1. retrieve problem and user information
        $uid = session()->get('user')->uid;
        $pid = $request->input('pid');
        $ans = trim($request->input('answer'));
        $user = UserInfo::where('uid', $uid)->first();
        if (!preg_match('/^[0-9]*$/', $pid))
            return ['status' => -1, 'msg' => 'Problem does not exist. This attempt will not negatively affect your submission.'];
        $problem = Problems::where('pid', $pid)->first();
        if (!$problem)
            return ['status' => -1, 'msg' => 'Problem does not exist. This attempt will not negatively affect your submission.'];

        // 2. check if user had accepted before
        $userac = Submission::where([
            ['uid', '=', $uid],
            ['pid', '=', $pid],
            ['status', '=', 1]
        ])->first();
        if ($userac) return ['status' => -1, 'msg' => 'You have already got accepted. Please do not submit again. This attempt will not negatively affect your submission.'];

        // 3. incorrect answer format and compare answer with the database, if not the same, return message
        if (!preg_match('/^[\w\s.]+$/', $ans) || $ans != $problem->pans) {
            // update problem total submission
            $problem->increment('psub');
            // update submission record
            Submission::create([
                'uid' => $uid,
                'pid' => $pid,
                'status' => 0
            ]);
            $user->increment('usersubmission');
            // update user information
            if ($user->usercoins > 0) {
                $user->decrement('usercoins');
                return ['status' => 0, 'msg' => 'Incorrect answer or answer format, please click submission tips for details. You lost 1 coin.'];
            } else {
                return ['status' => 0, 'msg' => 'Incorrect answer or answer format, please click submission tips for details.'];
            }
        } //4. if answer is correct
        else {
            // update problem total submission and acceptance
            $problem->increment('psub');
            $problem->increment('pacc');
            // update submission record
            Submission::create([
                'uid' => $uid,
                'pid' => $pid,
                'status' => 1
            ]);
            // update user information
            $user->increment('usersubmission');
            $user->increment('userac');
            $user->update([
                'usercoins' => $user->usercoins + $problem->preward
            ]);
            return ['status' => 1, 'msg' => 'Your answer is correct for all testcases, you received ' . $problem->preward . ' coins. <b>Refresh the page to check the solution.</b>'];
        }
    }
}
