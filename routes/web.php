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

//Courses
Route::resource('courses','CoursesController');
Route::post('/course/ajaxcreate', 'CoursesController@ajaxcreate');
Route::post('/course/ajaxdelete', 'CoursesController@ajaxdelete');
Route::post('/course/ajaxedit', 'CoursesController@ajaxedit');


//Categories
Route::resource('categories','CategorysController');
Route::post('/categories/ajax', 'CategorysController@ajax');
Route::post('/categories/ajaxdelete', 'CategorysController@ajaxdelete');
Route::post('/categories/ajaxcreate', 'CategorysController@ajaxcreate');
Route::get('/categories/publish/{cid}', 'CategorysController@checkpublish');
Route::post('category/course','CategorysController@setCourse');

//Levels
Route::get('/levels/create/{id}','LevelsController@create');
Route::post('/levels/{id}','LevelsController@store');
Route::delete('levels/delete/{lid}/{lnum}/{cid}','LevelsController@destroy');
Route::post('/level/adelete','LevelsController@destroy1');
Route::get('levels/{id}','LevelsController@index');
Route::post('level/questions','LevelsController@numOfQues');

//Questions
Route::get('/questions/{id}','QuestionsController@index');
Route::get('/questionsd/{id}','QuestionsController@indexdisabled');
Route::post('/questions','QuestionsController@display');
Route::post('/questions/{id}', 'QuestionsController@store');
Route::get('/questions/create/{id}','QuestionsController@create');
Route::get('/questions/{id}/edit','QuestionsController@edit');
Route::put('/questions/update/{id}','QuestionsController@update');
Route::post('/question/ajaxdelete', 'QuestionsController@ajaxdelete');
Route::post('/question/hide', 'QuestionsController@hide');

//Students
Route::get('/student/{cid}','StudentsController@index');
Route::post('/student/ajaxcreate', 'StudentsController@ajaxcreate');
Route::post('/student/ajaxdelete', 'StudentsController@ajaxdelete');
Route::post('/student/file', 'StudentsController@fileupload');

//Answers
// Route::post('/ques/hide', 'AnswersController@hide');

//Results
Route::get('/results','ResultsController@index');
Route::get('/stats/{id}','ResultsController@displaystats');
Route::get('/perform/{id}','ResultsController@perform');

//Maps
Route::get('/maps/{id}','MapsController@map');
Route::get('/mapslevel/{id}', 'MapsController@viewLevel');
Route::put('/mapsupdate', 'MapsController@updateLevel');

 Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
