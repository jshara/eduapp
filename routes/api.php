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
Route::get('/checkAns/{sid}&{cid}&{lnum}&{aid?}','ApiController@checkAns');
Route::get('/getRan/{num}','ApiController@getRandomLatLng');
Route::get('/getRan2/{num}','ApiController@getRandomLatLng2');
Route::get('/createGame/{userId}&{cid}','ApiController@createGameSession');
Route::get('/saveGame/{userId}&{cid}&{lnum}&{score}','ApiController@saveGameSession');
Route::get('/endGame/{userId}&{cid}&{lnum}&{score}','ApiController@endGameSession');
Route::get('/loadGame/{userId}&{cid}','ApiController@loadGameSession');
Route::get('/results/{userId}&{cid}','ApiController@loadResults');
Route::get('/update/{userId}','Apicontroller@refreshCoconuts');
Route::get('/visit/{userId}&{cocos}','ApiController@visitCoco');


Route::get('/game-over1/{cat_id}', function($cat_id){
    event(new \App\Events\gameOver($cat_id));
    // return redirect('categories');
});

Route::get('/refresh', function(){
    event(new \App\Events\refreshCoconuts);
    // return redirect('categories');
});