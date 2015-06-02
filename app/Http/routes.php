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

    Route::resource('users', 'ClientUsersController');
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
   echo Crypt::decrypt('eyJpdiI6ImVYYlwvbzNJbTRablBJWHBHdWJUaVp3PT0iLCJ2YWx1ZSI6IlFlVEVMV3VoYks3b09lMGpcL2tLYUxBck5BTkFkNVdCVzFSTUJrbEpiMkNFPSIsIm1hYyI6ImRiZDZiNGM4ODY4MTcyNzg1OTRmNjJiYmFkNjUxZjc5NTc2OTM5YjA0MWU1MTljYjAyNjY4YmU2YzdhZTlkMzUifQ==');
});
