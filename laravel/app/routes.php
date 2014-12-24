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
// Site routes
Route::get('/', 'SiteController@index');

// Temporary classroom route for mac to work with
Route::get('classroom', 'SiteController@classroom');
Route::get('admindash', 'SiteController@admindash');
Route::get('affiliatedash', 'SiteController@affiliatedash');
Route::get('classroomdash', 'SiteController@classroomdash');
Route::get('classroom', 'SiteController@classroom');
// temporary tracking route
Route::post('action-tracker', 'ActionController@track');

// Confide routes
Route::get('register', 'UsersController@create');
Route::get('register/{teacher_account}', 'UsersController@create');
Route::post('users', 'UsersController@store');
Route::get('login', 'UsersController@login');
Route::get('login-with-facebook', 'UsersController@loginWithFacebook');
Route::get('link-facebook', 'UsersController@linkFacebook');
Route::post('link-facebook', 'UsersController@doLinkFacebook');
Route::post('confirmation-code', 'UsersController@confirmationCode');
Route::get('login-with-google', 'UsersController@loginWithGoogle');
Route::get('link-google', 'UsersController@linkGooglePlus');
Route::post('link-google', 'UsersController@doLinkGooglePlus');
Route::post('login', 'UsersController@doLogin');
Route::get('account-confirmation/{code}', 'UsersController@confirm');
Route::get('forgot-password', 'UsersController@forgotPassword');
Route::post('forgot-password', 'UsersController@doForgotPassword');
Route::get('reset-password/{token}', 'UsersController@resetPassword');
Route::post('reset-password', 'UsersController@doResetPassword');
Route::get('logout', 'UsersController@logout');



// Admin Controller
Route::group(array('prefix'=>'administration'),function(){
    Route::resource('members', 'MembersController');
});

// Courses Controller
Route::get('courses/mycourses', 'CoursesController@myCourses');
Route::get('courses/categories', 'CoursesController@categories');
Route::get('courses/category/{slug}/{subcat}', 'CoursesController@subCategory');
Route::get('courses/category/{slug}', 'CoursesController@category');
Route::post('courses/{slug}/purchase', 'CoursesController@purchase');
Route::resource('courses', 'CoursesController');

// Instructors routes
Route::get('instructors', 'InstructorsController@index');
Route::get('instructors/start/{user}', 'InstructorsController@start');
Route::get('instructors/become-instructor', 'InstructorsController@become');
Route::post('instructors/become-instructor', 'InstructorsController@doBecome');
Route::resource('instructors', 'InstructorsController');

## Route Group for Profile
Route::group(['prefix' => 'profile'], function (){
    ## Profile Page /profile
    Route::get('/','ProfileController@index');

    ## POST call to upload a profile picture
    Route::post('upload-profile-picture', 'ProfileController@uploadProfilePicture');

    ## POST call to process additional data for initial profile set-up
    Route::post('store-new-profile', 'ProfileController@storeNewProfile');
    
    ## Polymorphic Test
    Route::get('polymorphic-test','ProfileController@polymorphicTest');

});
