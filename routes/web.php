<?php

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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Categories
Route::resource('categories','CategorysController');

//Levels
Route::get('/levels/create/{id}','LevelsController@create');
Route::post('/levels/{id}','LevelsController@store');
Route::delete('levels/delete/{lid}/{lnum}/{cid}','LevelsController@destroy');
Route::get('levels/{id}','LevelsController@index');
//this is just testing if it works
//I am making changes to my new branch
