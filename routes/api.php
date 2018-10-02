<?php

use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login1', 'ApiController@login');
Route::get('user', 'ApiController@student');

Route::get('/loginTest/{sid}&{pass}', 'ApiController@credentials');
Route::get('/cat', 'ApiController@getAllCat');
Route::get('/cat={id}', 'ApiController@getLevel');
Route::get('/numLev/{cat_id}', 'ApiController@checkHowManyLevel');
Route::get('/nextLevel/current={lev_id}&cat={cat_id}', 'ApiController@loadNextLevel');
Route::get('/loadQuestions/{id}&{catid}', 'ApiController@loadQuestion');
// Route::get('/checkAns/{id}','ApiController@checkAns');
Route::get('/checkAns/{cid}&{lnum}&{id?}', 'ApiController@checkAns');
Route::get('/getRan/{num}', 'ApiController@getRandomLatLng');
Route::get('/createGame/{userId}&{cid}&{lnum}', 'ApiController@createGameSession');
Route::get('/saveGame/{userId}&{cid}&{lnum}&{score}', 'ApiController@saveGameSession');
Route::get('/loadGame/{userId}&{cid}', 'ApiController@loadGameSession');

// Route::group([
//     'prefix' => 'auth'
// ], function () {
//     Route::post('login', 'StudentController@login');
//     Route::post('signup', 'StudentController@signup');

//     Route::group([
//         'middleware' => 'auth:api'
//     ], function () {
//         Route::get('logout', 'AuthController@logout');
//         Route::get('user', 'AuthController@user');
//     });
// });
