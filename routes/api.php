<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1'], function(){

    Route::group(['prefix' => 'user'], function(){
        Route::post('signin', 'UserController@signIn');
        Route::post('signup', 'UserController@signUp');
    });

    Route::group(['prefix' => 'endgame'], function(){
        Route::post('/', 'MatchController@endMatch');
    });

    Route::group(['prefix' => 'leaderboard'], function(){
        Route::get('/', 'MatchController@leaderBoard');
    });

});
