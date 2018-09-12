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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/cat','ApiController@getAllCat');
Route::get('/cat={id}','ApiController@getLevel');
Route::get('/numLev/{cat_id}','ApiController@checkHowManyLevel');
Route::get('/nextLevel/current={lev_id}&cat={cat_id}','ApiController@loadNextLevel');
Route::get('/loadQuestions/{id}&{catid}','ApiController@loadQuestion');
// Route::get('/checkAns/{id}','ApiController@checkAns');
Route::get('/checkAns/{cid}&{lnum}&{id?}','ApiController@checkAns');
Route::get('/getRan/{num}','ApiController@getRandomLatLng');