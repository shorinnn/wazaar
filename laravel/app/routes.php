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

Route::get('/', function()
{
	return View::make('hello');
});
//

// Confide routes
Route::get('register', 'UsersController@create');
Route::post('users', 'UsersController@store');
Route::get('login', 'UsersController@login');
Route::get('loginWithFacebook', 'UsersController@loginWithFacebook');
Route::get('loginWithGoogle', 'UsersController@loginWithGoogle');
Route::post('login', 'UsersController@doLogin');
Route::get('account_confirmation/{code}', 'UsersController@confirm');
Route::get('forgot_password', 'UsersController@forgotPassword');
Route::post('forgot_password', 'UsersController@doForgotPassword');
Route::get('reset_password/{token}', 'UsersController@resetPassword');
Route::post('reset_password', 'UsersController@doResetPassword');
Route::get('logout', 'UsersController@logout');
