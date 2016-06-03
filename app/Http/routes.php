<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::auth();

Route::get('/dashboard', [
    'uses' => 'HomeController@index',
    'as' => 'dashboard'
]);

Route::get('/liked', [
    'uses' => 'HomeController@liked',
    'as' => 'liked'
]);

Route::get('/quote/{quote_id}/like', [
   'uses' => 'HomeController@like',
    'as' => 'user.like.quote'
]);

Route::get('/quote/{quote_id}/unlike', [
    'uses' => 'HomeController@unlike',
    'as' => 'user.unlike.quote'
]);

Route::group(['prefix' => 'api/v1', 'middleware' => 'auth:api', 'namespace' => 'Api'], function(){
    Route::resource('users', 'UsersController', ['except' => ['create', 'edit']]); // Api\UsersController
    Route::resource('authors', 'AuthorsController', ['except' => ['create', 'edit']]); // Api\AuthorsController
    Route::resource('quotes', 'QuotesController', ['except' => ['create', 'edit']]); // Api\QuotesController
    Route::resource('authors.quotes', 'AuthorsQuotesController', ['except' => ['create', 'edit']]); // Api\AuthorsQuotesController
    Route::resource('users.quotes', 'UsersQuotesController', ['only' => ['index', 'show', 'destroy']]); // Api\UsersQuotesController
});