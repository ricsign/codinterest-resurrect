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
    Route::get('articles','ArticlesController@allarticles');
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
});
