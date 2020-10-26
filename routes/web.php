<?php

//  Name: Richard Shuai
//
//  Date Start: September 8th
//
//  Date Completed: October 23rd
//
//  Class: Computer Science 30
//
//  Teacher: Mr. Schellenberg
//
//  Project: Capstone Coding Project (Codinterest)
//
//  Extra For Expert:
//    1. Knowledge from CS 30: Utilize lots of stuff learned in this semester, such as array, map, recursion, object-oriented programming, libraries and etc.
//    2. Knowledge from outside the class: A considerable amount of code is from self-learning, I did not use others code (except libraries), majority of it is learned from official documentation, and I implemented them on my own.
//    3. Effort: This website is a medium-scale program, I developed front end, back end, problems & solutions and database all by myself.
//               I did put lots of effort in this project. On the way, I conquered a few challenging modules I've never done before: MVC, ajax, email activation and reset, captcha verification code and a lot more.
//               During developing, my laptop crashed, so I lost at least 20% of my progress at that time, I have to revert to the previous version and set up a new local enviornment, therefore I have 2 repos on Github: codinterest and codinterest-resurrect.
//
//  Note For Grading:
//    To run laravel, you will need to install XAMPP(recommended)/Apache+MySQL and package manager Composer
//
//    ============================== IMPORTANT FILES INFORMATION ==============================
//    All SQL files are stored in \App\SQL directory
//    All controllers are stored in \App\Http\Controllers directory
//    All models are stored in \App\Models directory
//    All views are stored in \Resources\views directory
//    All external JS, CSS, HTML, images, articles, problems are stored in \Public directory
//    All configurations are stored in \Config directory
//    All middlewares are stored in \App\Http\Middlewares directory


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// index page
Route::get('/',function (){
    return redirect(url('/public/index'));
});


// public page route
// pages that doesn't need a signed account to view
Route::group(['prefix'=>'public'],function () {
    Route::get('index',function(){
        return view('index');
    });

    // sign in and sign up page
    Route::get('signup','SignController@signup');
    Route::get('signin','SignController@signin');

    // processing request of signup and sign in
    Route::post('dosignup','SignController@dosignup');
    Route::post('dosignin','SignController@dosignin');

    // email activation
    Route::get('emailactivation','SignController@emailactivation');
//    Route::get('lol',function (){return view('nonsite.emailactivation');}); //testing

    // vercode route
    Route::get('captcha/vercode','SignController@vercode');

    // route of all problems page
    Route::get('allproblems','ProblemsController@allproblems');

    // route of problems grouped by its pterrid
    Route::get('getproblems/{pterrid}','ProblemsController@getproblems')
    ->where('pterrid','[123456]');

    // route of a single problem
    Route::get('getsingleproblem/{pid}','ProblemsController@getsingleproblem')
        ->where('pid','[0-9]+');

    // route of myaccount
    Route::get('myaccount/{uid}','InfoController@myaccount')
        ->where('uid','[0-9]+');

    // route of redeem page
    Route::get('redeem','RedeemController@redeempage');

    // route of all ranking page
    Route::get('ranking','RankingController@rankingpage');

    // route of articles page
    Route::get('allarticles','ArticlesController@allarticles');


    // route of a single article page
    Route::get('getsinglearticle/{aid}','ArticlesController@getsinglearticle')
        ->where('aid','[0-9]+');

    // route of contribute page
    Route::get('contribute',function (){
        return view('contribute');
    });

    // route of recreation page
    Route::get('recreation',function (){
        return view('recreation');
    });

    // route of talk page
    Route::get('talks','TalksController@talks');

    // route of single talk page
    Route::get('getsingletalk/{tid}','TalksController@getsingletalk')
        ->where('tid','[0-9]+');

    // route handling topic search result
    Route::get('topicsearchresult','TalksController@topicsearchresult');

    // choose topics
    Route::get('choosetopics/{tids}','TalksController@choosetopics')
        ->where('tids','[0-9&]+');
    Route::get('choosetopics','TalksController@choosetopics');

    // reset password email sender
    Route::get('resetpassword','SignController@resetpassword');

    // reset password handler
    Route::get('handlereset','SignController@handlereset');

    // reset password finisher
    Route::post('finishreset','SignController@finishreset');

    // playground
    Route::get('playground',function (){
        return File::get(public_path().'/html/playground.html');
    });
});


// protected page route
// pages that must need a signed account to view
// Middleware will be implemented
Route::group(['prefix'=>'protected','middleware'=>'checksigned'],function (){
    // processing personal description change
    Route::post('saveuserdesc','InfoController@saveuserdesc');

    // processing signout
    Route::get('signout','SignController@signout');

    // processing submission
    Route::post('submission','SubmissionController@submission');

    // get solution page
    Route::get('solution/{pid}','ProblemsController@solution')
        ->where('pid','[0-9]+');

    // redeem item page
    // item 1: key, 2: 10 keys, 3: silver coder, 4: gold coder + 5 keys, 5: red coder + 50 keys
    Route::get('redeemitem/{item}','RedeemController@redeemitem')
        ->where('item','[12345]');

    // skip problem page
    Route::get('skip/{pid}','SubmissionController@skip')
        ->where('pid','[0-9]+');

    // post comment
    Route::post('postcomment','CommentsController@postcomment');

    // delete comment
    Route::get('deletecomment/{cid}','CommentsController@deletecomment')
        ->where('cid','[0-9]+');

    // post a talk(page)
    Route::get('createtalk','TalksController@createtalkpage');

    // edit a talk(page)
    Route::get('edittalk/{tid}','TalksController@edittalkpage');

    // post a talk(handling)
    Route::post('newtalk','TalksController@newtalk');

    // edit a talk(page)
    Route::post('handleedittalk','TalksController@handleedittalk');

    // post a reply
    Route::post('postreply','CommentsController@postreply');

    // delete reply
    Route::get('deletereply/{crid}','CommentsController@deletereply')
        ->where('rid','[0-9]+');
});
