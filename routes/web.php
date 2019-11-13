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

Route::get('/login', "Auth\LoginController@login_view");
Route::post('/login', "Auth\LoginController@login");
Route::get('/logout', "Auth\LoginController@logout");
Route::get('/register', "Auth\RegisterController@register_view");
Route::post('/register', "Auth\RegisterController@register");
Route::get('/question', "QuestionController@question_view");
Route::get('/question/add', "QuestionController@add_view");
Route::post('/question/add', "QuestionController@add");
Route::get('/question/edit', "QuestionController@edit_view");
Route::post('/question/edit', "QuestionController@edit");
Route::get('/topic', "TopicController@topic_view");
Route::get('/topic/add', "TopicController@add_view");
Route::post('/topic/add', "TopicController@add");
Route::get('/topic/edit', "TopicController@edit_view");
Route::post('/topic/edit', "TopicController@edit");
Route::get('/', "HomeController@index");

Route::get('/home', function () {
    return view('/');
});
