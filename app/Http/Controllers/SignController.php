<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\Models\UserSign;
use Dotenv\Validator;
use Illuminate\Http\Request;

// use captcha vercode namespace
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class SignController extends Controller
{
    public function signup(){
        return view('signup');
    }

    public function signin(){
        return view('signin');
    }

    public function vercode(){
        $phrase = new PhraseBuilder();
        $code = $phrase->build(6); // 6-digits vercode
        $builder = new CaptchaBuilder($code,$phrase);
        // set properties
        $builder->setBackgroundColor(random_int(230,255),random_int(230,255),random_int(230,255));
        $builder->setMaxAngle(10);
        $builder->setMaxBehindLines(3);
        $builder->setMaxFrontLines(3);

        $builder->build($width=180,$height=50,$font=null);
        // retrieve vercode's phrase
        $phrase = $builder->getPhrase();
        // store in session
        \session()->flash('vercode',$phrase);
        // generate code as jpeg
        header('Cache-Control:no-cache,must-revalidate');
        header('Content-Type:image/jpeg');
        $builder->output();
    }

    public function emailactivation(Request $request){
        // find user
        $user = UserSign::findOrFail($request->uid);
        if($request->usertoken != $user->usertoken) return 'Invalid Activation! Please try again!';

        $res = $user->update([
            'is_activated'=>1,
            'usertoken'=>md5('token'.$user->email.$user->username.time().'token2')
        ]);

        if($res){
            UserInfo::where('uid','=',$user->uid)->update([
                'userprivil' => 0
            ]);
            return redirect('/public/signin')->with('msg','Congratulations! Account is activated, please sign back in!');
        }
        else return redirect('/public/signup')->withErrors("Sorry, we're currently unable to activate your account, please try again!");
    }

    public function dosignup(Request $request){
        // 1. validate user's input
        $session_vercode = strtoupper(\request()->session()->get('vercode')); // session vercode uppercased
        $request->merge(['vercode'=>strtoupper($request->input('vercode'))]); // make vercode user input uppercased

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
        $usertoken = md5('token'.$request->input('email').$request->input('username').time().'token2');
        $user = UserSign::create([
            'username'=>$request->input('username'),
            'password'=>Hash::make($request->input('password')),
            'email'=>$request->input('email'),
            'usertoken'=>$usertoken,
            'is_activated'=>0
        ]);
        if(!$user) return redirect('/public/signup')->withErrors('Unknown errors had occured');

        $userinfo = UserInfo::create([
            'uid' => $user->uid,
            'usercoins'=> 0,
            'userac' => 0,
            'usersubmission' => 0,
            'userprivil' => -1,
            'userkeys' => 0
        ]);
        if(!$userinfo) return redirect('/public/signup')->withErrors('Unknown errors had occured');

        // 3. send activation link
        Mail::send('nonsite.emailactivation',['user'=>$user],function($m) use ($user){
            $m->from('codinterest@noreply.com','Account Validation');
            $m->to($user->email,$user->username)->subject('Codinterest Account Activation');
        });
        // 4. redirect to signin page
//        echo $user->uid;
//        echo "<script>alert('You have successfully signed up, please check your email to activate your account, then sign back in again.');</script>";
        return redirect('/public/signin')->with('msg','You have successfully signed up, please check your email to activate your account, then sign back in again. (The activation email might be in the spams folder, the link may take up to 5 minutes to deliver.)');
    }

    public function dosignin(Request $request){
        // 1. validate user's input
        $session_vercode = strtoupper(\request()->session()->get('vercode')); // session vercode uppercased
        $request->merge(['vercode'=>strtoupper($request->input('vercode'))]); // make vercode user input uppercased

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
        $usertoken = md5('token'.$request->input('email').$request->input('username').time().'token2');
        $user = UserSign::where('username',$request->input('username'))->first();

        if(!$user) return redirect('/public/signin')->withErrors('Username or password is incorrect!'); //can't find user

        if(!Hash::check($request->input('password'),$user->password)) return redirect('/public/signin')->withErrors('Username or password is incorrect!'); //password doesn't match

        if($user->is_activated == 0) return redirect('/public/signin')->withErrors('Please activate your account first! We sent an email with your activation link, please check spams.'); //unactivated


        // 3. Store user info in session
        session()->put('user',$user);

        // 4. Redirect to index
        return redirect('/public/index')->with('success_signin','Welcome back, '.$user->username.'!');
    }

    public function signout(){
        session()->flush();
        return redirect('/public/signin');
    }
}


