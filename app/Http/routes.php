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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'api', 'middleware' => 'client'], function (){

    Route::group(['prefix' => 'users'], function (){
        Route::resource('/', 'ClientUsersController');
        Route::post('batch','ClientUsersController@addBatch');
    });
    Route::resource('templates', 'TemplateController');

    Route::group(['prefix' => 'email-requests'], function (){
        Route::post('create', 'EmailRequestsController@create');
    });

    Route::get('/', function(){
       $result = Mail::send('welcome',[], function ($message){
           $message->to('albertmaranian@gmail.com');
       });


        if ($result) {
            echo '<pre>';
            print_r($result->json());
            echo '</pre>';
        }
    });
});

Route::get('test', function(){
    $eReq = \Delivered\EmailRequest::find(6);
    event(new \Delivered\Events\EmailRequestWasMade($eReq));
});