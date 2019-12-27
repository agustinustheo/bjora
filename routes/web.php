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

Route::get('/answer/{id}', "QuestionController@answer_view");
Route::post('/answer/add', "QuestionController@add_answer");
Route::get('/answer/edit/{id}', "QuestionController@edit_answer_view");
Route::post('/answer/edit', "QuestionController@edit_answer");

Route::get('/answer/delete/{id}', "QuestionController@delete_answer");

Route::get('/', "HomeController@index");
Route::get('/search', "HomeController@search");

Route::get('/home', function () {
    return redirect('/');
});

Route::group(['namespace' => 'Admin','prefix' => 'admin','middleware'=>'AdminCheck'], function () {
	Route::group(['prefix' => 'user'], function () {
        Route::get('/all', 'UserController@getAllUser')->name('view-all-user');
        Route::get('/add', 'UserController@showAddUserForm')->name('add-user-form');
        Route::post('/add', 'UserController@addUser')->name('add-user');
        Route::get('/edit/{id}', 'UserController@showEditUserForm')->name('edit-user-form');
        Route::post('/edit', 'UserController@editUser')->name('edit-user');
        Route::post('/delete/{id}', 'UserController@deleteUser')->name('delete-user');
    });

    Route::group(['prefix' => 'topic'], function () {
        Route::get('/all', 'TopicController@getAllTopic')->name('view-all-topic');
        Route::get('/add', 'TopicController@showAddTopicForm')->name('add-topic-form');
        Route::post('/add', 'TopicController@addTopic')->name('add-topic');
        Route::get('/edit/{id}', 'TopicController@showEditTopicForm')->name('edit-topic-form');
        Route::post('/edit', 'TopicController@editTopic')->name('edit-topic');
        Route::post('/delete/{id}', 'TopicController@deleteTopic')->name('delete-topic');
    });

    Route::group(['prefix' => 'question'], function () {
        Route::get('/all', "QuestionController@master_view")->name('view-all-question');
    });
});
