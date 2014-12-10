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
Route::get('/main','ShowController@getMain');


Route::get('/signup','UserController@getSignup' );
Route::get('/login', 'UserController@getLogin' );
Route::post('/signup', 'UserController@postSignup' );
Route::post('/login', 'UserController@postLogin' );
Route::get('/logout', 'UserController@getLogout' );

Route::get('/owner/create', 'OwnerController@getOwner');
Route::post('/owner/create', 'OwnerController@postOwner');

Route::get('/book/create', 'BookController@getCreate');
Route::post('/book/add', 'BookController@postCreate');
Route::get('/book/edit/{id}', 'BookController@getEdit');
Route::post('/book/edit', 'BookController@postEdit');
Route::post('/book/create', 'BookController@showGoogleBooks');
Route::get('/book/list', 'BookController@getSearch');
Route::post('/book/list', 'BookController@postSearch');
Route::get('/book/rent','BookController@getRent');
Route::get('/book/loan','BookController@getLoan');
Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'UserController@confirm'
]);