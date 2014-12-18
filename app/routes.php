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
Route::post('/book/create', 'BookController@showGoogleBooks');

Route::get('/book/edit/{id}', 'BookController@getEdit');
Route::post('/book/edit', 'BookController@postEdit');


Route::get('/book/list', 'BookController@getSearch');
Route::post('/book/list', 'BookController@postSearch');

Route::get('/msgs/list', 'MessageController@getList');
Route::post('/msgs/list', 'MessageController@postList');

Route::get('/book/rent','RenterController@getRent');
Route::post('/book/rent','RenterController@postRent');

Route::get('/book/loan','RenterController@getLoan');
Route::post('/book/loan','RenterController@postLoan');


Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'UserController@confirm'
]);

Route::get('password/reset', array(
    'uses' => 'RemindersController@getRemind',
    'as' => 'pages.remind'
));

Route::post('password/reset', array(
    'uses' => 'RemindersController@postRemind',
    'as' => 'pages.request'
));

Route::get('password/reset/{token}', array(
    'uses' => 'RemindersController@getReset',
    'as' => 'pages.reset'
));

Route::post('password/reset/{token}', array(
    'uses' => 'RemindersController@postReset',
    'as' => 'pages.update'
));

# /app/routes.php
Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>environment.php</h1>';
    $path   = base_path().'/environment.php';

    try {
        $contents = 'Contents: '.File::getRequire($path);
        $exists = 'Yes';
    }
    catch (Exception $e) {
        $exists = 'No. Defaulting to `production`';
        $contents = '';
    }

    echo "Checking for: ".$path.'<br>';
    echo 'Exists: '.$exists.'<br>';
    echo $contents;
    echo '<br>';

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(Config::get('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    print_r(Config::get('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
    try {
        $results = DB::select('SHOW DATABASES;');
        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
        echo "<br><br>Your Databases:<br><br>";
        print_r($results);
    }
    catch (Exception $e) {
        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
    }

    echo '</pre>';

});