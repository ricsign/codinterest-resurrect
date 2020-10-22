<?php

// This controller controls all the logics regarding the sign in, sign out, sign up, and reset password
// or all operations regarding account manipulations

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\Models\UserSign;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use function session;

// use captcha vercode namespace

class SignController extends Controller
{
    // sign-up page
    public function signup()
    {
        return view('signup');
    }


    // sign-in page
    public function signin()
    {
        return view('signin');
    }


    // verification code
    public function vercode()
    {
        $phrase = new PhraseBuilder();
        $code = $phrase->build(6); // 6-digits vercode
        $builder = new CaptchaBuilder($code, $phrase);
        // set properties
        $builder->setBackgroundColor(random_int(230, 255), random_int(230, 255), random_int(230, 255));
        $builder->setMaxAngle(10);
        $builder->setMaxBehindLines(3);
        $builder->setMaxFrontLines(3);

        $builder->build($width = 180, $height = 50, $font = null);
        // retrieve vercode's phrase
        $phrase = $builder->getPhrase();
        // store in session
        session()->flash('vercode', $phrase);
        // generate code as jpeg
        header('Cache-Control:no-cache,must-revalidate');
        header('Content-Type:image/jpeg');
        $builder->output();
    }


    // activate account information
    public function emailactivation(Request $request)
    {
        // find user
        $user = UserSign::findOrFail($request->uid);
        if ($request->usertoken != $user->usertoken) return 'Invalid Activation! Please try again!';

        $res = $user->update([
            'is_activated' => 1,
            'usertoken' => md5('token' . $user->email . $user->username . time() . 'token2')
        ]);

        if ($res) {
            UserInfo::where('uid', '=', $user->uid)->update([
                'userprivil' => 0
            ]);
            return redirect('/public/signin')->with('msg', 'Congratulations! Account is activated, please sign back in!');
        } else return redirect('/public/signup')->withErrors("Sorry, we're currently unable to activate your account, please try again!");
    }


    // function that handle sign up request logic
    public function dosignup(Request $request)
    {
        // 1. validate user's input
        $session_vercode = strtoupper(\request()->session()->get('vercode')); // session vercode uppercased
        $request->merge(['vercode' => strtoupper($request->input('vercode'))]); // make vercode user input uppercased

//        try {
        $this->validate($request, [
            'username' => 'required|min:3|max:20|regex:/^[\w]*$/|unique:user_sign,username',
            'password' => 'required|min:6',
            'repassword' => 'required|same:password',
            'email' => 'required|email|unique:user_sign,email',
            'vercode' => 'required|min:6|max:6|alpha_num|in:' . $session_vercode,
        ]);
//        } catch (ValidationException $e) {
//            return redirect('/public/signup')->withErrors('Unknown errors had occured');
//        }

        // 2. write into the database
        $usertoken = md5('token' . $request->input('email') . $request->input('username') . time() . 'token2');
        $user = UserSign::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'email' => $request->input('email'),
            'usertoken' => $usertoken,
            'is_activated' => 0
        ]);
        if (!$user) return redirect('/public/signup')->withErrors('Unknown errors had occured');

        $userinfo = UserInfo::create([
            'uid' => $user->uid,
            'usercoins' => 0,
            'userac' => 0,
            'usersubmission' => 0,
            'userprivil' => -1,
            'userkeys' => 0
        ]);
        if (!$userinfo) return redirect('/public/signup')->withErrors('Unknown errors had occured');

        // 3. send activation link
        Mail::send('nonsite.emailactivation', ['user' => $user], function ($m) use ($user) {
            $m->from('codinterest@noreply.com', 'Account Activation');
            $m->to($user->email, $user->username)->subject('Codinterest Account Activation');
        });
        // 4. redirect to signin page
//        echo $user->uid;
//        echo "<script>alert('You have successfully signed up, please check your email to activate your account, then sign back in again.');</script>";
        return redirect('/public/signin')->with('msg', 'You have successfully signed up, please check your email to activate your account, then sign back in again. (The activation email might be in the spams folder, the link may take up to 5 minutes to deliver.)');
    }


    // handle sign in logic
    public function dosignin(Request $request)
    {
        // 1. validate user's input
        $session_vercode = strtoupper(\request()->session()->get('vercode')); // session vercode uppercased
        $request->merge(['vercode' => strtoupper($request->input('vercode'))]); // make vercode user input uppercased

//        try {
        $this->validate($request, [
            'username' => 'required|min:3|max:20|regex:/^[\w]*$/',
            'password' => 'required|min:6',
            'vercode' => 'required|min:6|max:6|alpha_num|in:' . $session_vercode,
        ]);
//        } catch (ValidationException $e) {
//            return redirect('/public/signup')->withErrors('Unknown errors had occured');
//        }

        // 2. Check the database
        $usertoken = md5('token' . $request->input('email') . $request->input('username') . time() . 'token2');
        $user = UserSign::where('username', $request->input('username'))->first();

        if (!$user) return redirect('/public/signin')->withErrors('Username or password is incorrect!'); //can't find user

        if (!Hash::check($request->input('password'), $user->password)) return redirect('/public/signin')->withErrors('Username or password is incorrect!'); //password doesn't match

        if ($user->is_activated == 0) return redirect('/public/signin')->withErrors('Please activate your account first! We sent an email with your activation link, please check spams.'); //unactivated


        // 3. Store user info in session
        session()->put('user', $user);

        // 4. Redirect to index
        return redirect('/public/index')->with('success_signin', 'Welcome back, ' . $user->username . '!');
    }


    // handle sign out logic
    public function signout()
    {
        session()->flush();
        return redirect('/public/signin');
    }


    // reset the password page
    public function resetpassword(Request $request){
        // 1. find the user
        $user = UserSign::where('uid',$request->input('uid'))->first();
        if(!$user) return ['status'=>-1,'msg'=>'Failed to send the reset link, please try again!'];

        // 2. send the reset link
        Mail::send('nonsite.emailreset', ['user' => $user], function ($m) use ($user) {
            $m->from('codinterest@noreply.com', 'Reset Your Password Now');
            $m->to($user->email, $user->username)->subject('Codinterest Reset Password');
        });
        return ['status'=>1,'msg'=>'Reset email sent, please click the link to reset the password!'];
    }


    // reset password handling logic
    public function handlereset(Request $request){
        // 1. find user
        $user = UserSign::findOrFail($request->uid);
        if ($request->usertoken != $user->usertoken) return 'Invalid Activation! Please try again!';

        // 2. return view to let user re-enter the password
        return view('reenter-password',compact('user'));
    }


    // finish reset password
    public function finishreset(Request $request){
        // 1. validate
        $this->validate($request, [
            'password' => 'required|min:6',
            'repassword' => 'required|same:password'
        ]);

        // 2. find user and compare token
        $user = UserSign::where('uid',$request->input('uid'))->first();
        if(!$user) return redirect('/public/signin')->withErrors('Failed to reset your password, please try again!');
        if($request->input('usertoken') != $user->usertoken) return redirect('/public/signin')->withErrors('Failed to reset your password, please try again!');

        // 3. update user's data, clear the session and redirect
        $res = $user->update([
            'password' => Hash::make($request->input('password')),
            'usertoken' => md5('token' . $user->email . $user->username . time() . 'token2')
        ]);
        session()->flush();
        if($res) return redirect('/public/signin')->with('msg','Congratulations! You successfully reset your password!');
        return redirect('/public/signin')->withErrors('Failed to reset your password, please try again!');

    }

}


