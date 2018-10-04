<?php

use Illuminate\Http\Request;

Route::post('/loginUser','ApiController@login');
Route::get('/cat','ApiController@getCat');
Route::get('/catGet/{id}','ApiController@getAllCat');
Route::get('/CompCat/{userId}','ApiController@getCompletedCat');
Route::get('/SavedCat/{userId}','ApiController@getSavedCat');
Route::get('/cat={id}','ApiController@getLevel');
Route::get('/numLev/{cat_id}','ApiController@checkHowManyLevel');
Route::get('/nextLevel/current={lev_id}&cat={cat_id}','ApiController@loadNextLevel');
Route::get('/loadLevel/{catId}&{levNum}&{userId}&{score}','ApiController@loadLevel');
Route::get('/loadQuestions/{id}&{catid}','ApiController@loadQuestion');
// Route::get('/checkAns/{id}','ApiController@checkAns');
Route::get('/checkAns/{cid}&{lnum}&{id?}','ApiController@checkAns');
Route::get('/getRan/{num}','ApiController@getRandomLatLng');
Route::get('/getRan2/{num}','ApiController@getRandomLatLng2');
Route::get('/createGame/{userId}&{cid}','ApiController@createGameSession');
Route::get('/saveGame/{userId}&{cid}&{lnum}&{score}','ApiController@saveGameSession');
Route::get('/endGame/{userId}&{cid}&{lnum}&{score}','ApiController@endGameSession');
Route::get('/loadGame/{userId}&{cid}','ApiController@loadGameSession');
