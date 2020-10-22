<?php

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

Route::get('/',function (){
    return redirect(url('/public/index'));
});


// public page route
// pages that doesn't need a signed account to view
Route::group(['prefix'=>'public'],function () {
    Route::get('index',function(){
        return view('index');
    });
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


});

// protected page route
// pages that must need a signed account to view
// Middleware will be implemented
Route::group(['prefix'=>'protected','middleware'=>'checksigned'],function (){

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
