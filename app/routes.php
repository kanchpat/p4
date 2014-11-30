<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'IndexController@getIndex');
Route::get('/about','ShowController@getAbout');
Route::get('/contact','ShowController@getContact');

Route::get('/signup','UserController@getSignup' );
Route::get('/login', 'UserController@getLogin' );
Route::post('/signup', 'UserController@postSignup' );
Route::post('/login', 'UserController@postLogin' );
Route::get('/logout', 'UserController@getLogout' );

Route::get('/book/create', 'BookController@getCreate');
Route::post('/book/create', 'BookController@postCreate');
Route::get('/book/list', 'BookController@getSearch');