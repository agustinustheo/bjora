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

Route::get('/login', [ 'as' => 'login', 'uses' => "Auth\LoginController@login_view"]);
Route::post('/login', "Auth\LoginController@login");
Route::get('/logout', "Auth\LoginController@logout");
Route::get('/register', "Auth\RegisterController@register_view");
Route::post('/register', "Auth\RegisterController@register");

Route::get('/question', "QuestionController@question_view");
Route::get('/question/add', "QuestionController@add_view");
Route::post('/question/add', "QuestionController@add");
Route::get('/question/edit/{id}', "QuestionController@edit_view");
Route::post('/question/edit', "QuestionController@edit");
Route::get('/question/delete/{id}', "QuestionController@delete");
Route::get('/question/status/{id}', "QuestionController@toggle_status");
Route::get('/question/master', "QuestionController@master_view");

Route::get('/answer/{id}', "QuestionController@answer_view");
Route::post('/answer/add', "QuestionController@add_answer");
Route::get('/answer/edit/{id}', "QuestionController@edit_answer_view");
Route::post('/answer/edit', "QuestionController@edit_answer");

Route::get('/answer/delete/{id}', "QuestionController@delete_answer");
Route::get('/topic', "TopicController@topic_view");
Route::get('/topic/add', "TopicController@add_view");
Route::post('/topic/add', "TopicController@add");
Route::get('/topic/edit/{id}', "TopicController@edit_view");
Route::post('/topic/edit', "TopicController@edit");

Route::get('/', "HomeController@index");

Route::get('/home', function () {
    return redirect('/');
});
