<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*-------------------Video API------------------------*/
Route::get('video','videoController@index');
Route::get('video/{id}','videoController@show');

Route::post('video','videoController@store');
Route::put('video','videoController@store');

Route::delete('video/{id}','videoController@destroy');

Route::get('video/orderBy/{orderBy}','videoController@orderBy');

/*----------------------END------------------------*/

/*--------------------User API ---------------------*/

Route::post('user/create','userController@store');
Route::put('user/create','userController@store');

Route::post('user/login','userController@login');

Route::post('user/like','userController@like');
Route::get('user/likes/{id}','userController@totalLike');

Route::put('user/dislike','userController@dislike');
Route::get('user/dislikes/{id}','userController@totalDislike');

Route::post('user/comment','userController@addComment');
Route::put('user/comment','userController@addComment');

/*-----------------------END------------------------*/