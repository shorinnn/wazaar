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

// Course Categories
Route::get('coursecategories/subcategories', 'CoursesCategoriesController@subcategories');
// Courses Controller
Route::get('courses/mycourses', 'CoursesController@myCourses');
Route::get('courses/categories', 'CoursesController@categories');
Route::get('courses/category/{slug}/{subcat}', 'CoursesController@subCategory');
Route::get('courses/category/{slug}', 'CoursesController@category');
Route::post('courses/{slug}/purchase', 'CoursesController@purchase');
Route::get('courses/{slug}/curriculum', 'CoursesController@curriculum');
Route::resource('courses', 'CoursesController');
// Modules routes
Route::resource('modules', 'ModulesController');

// Lessons
Route::group(['prefix' => 'lessons'], function(){
    Route::get('/{slug}', 'LessonsController@index');
});
// Instructors routes
Route::get('instructors', 'InstructorsController@index');
Route::get('instructors/start/{user}', 'InstructorsController@start');
Route::get('instructors/become-instructor', 'InstructorsController@become');
Route::post('instructors/become-instructor', 'InstructorsController@doBecome');
Route::resource('instructors', 'InstructorsController');

## Route Group for Profile
Route::group(['prefix' => 'profile'], function (){
    ## Profile Page /profile
    Route::get('/', 'ProfileController@index');
    ## POST call to upload a profile picture
    Route::post('upload-profile-picture', 'ProfileController@uploadProfilePicture');
    ## POST call to process additional data for initial profile set-up
    Route::post('store-new-profile', 'ProfileController@storeNewProfile');
    ##
    Route::post('{id}/update', 'ProfileController@update');
    ## Polymorphic Test
    Route::get('polymorphic-test', 'ProfileController@polymorphicTest');

});


## Route Group Videos Manager
Route::group(['prefix' => 'video'], function(){
    Route::get('add','VideosController@add');
    Route::post('upload', 'VideosController@doUpload');
    Route::post('sns/callback', 'VideosController@snsCallback');
});


Route::get('test', function (){
   $json = '
{
  "Type" : "Notification",
  "MessageId" : "ea2b724f-6c02-5096-8078-3f66ceb81884",
  "TopicArn" : "arn:aws:sns:us-east-1:932188653619:TranscodeTopic",
  "Subject" : "Amazon Elastic Transcoder has finished transcoding job 1420795973893-ki3338.",
  "Message" : "{\n  \"state\" : \"COMPLETED\",\n  \"version\" : \"2012-09-25\",\n  \"jobId\" : \"1420795973893-ki3338\",\n  \"pipelineId\" : \"1420442490328-k9je9y\",\n  \"input\" : {\n    \"key\" : \"JLQavt8PylmckTMS\"\n  },\n  \"outputs\" : [ {\n    \"id\" : \"1\",\n    \"presetId\" : \"1351620000001-000061\",\n    \"key\" : \"JLQavt8PylmckTMS1351620000001000061.mp4\",\n    \"thumbnailPattern\" : \"JLQavt8PylmckTMS1351620000001000061-{count}\",\n    \"status\" : \"Complete\",\n    \"duration\" : 26,\n    \"width\" : 320,\n    \"height\" : 240\n  }, {\n    \"id\" : \"2\",\n    \"presetId\" : \"1351620000001-000040\",\n    \"key\" : \"JLQavt8PylmckTMS1351620000001000040.mp4\",\n    \"thumbnailPattern\" : \"JLQavt8PylmckTMS1351620000001000040-{count}\",\n    \"status\" : \"Complete\",\n    \"duration\" : 26,\n    \"width\" : 320,\n    \"height\" : 240\n  }, {\n    \"id\" : \"3\",\n    \"presetId\" : \"1351620000001-000020\",\n    \"key\" : \"JLQavt8PylmckTMS1351620000001000020.mp4\",\n    \"thumbnailPattern\" : \"JLQavt8PylmckTMS1351620000001000020-{count}\",\n    \"status\" : \"Complete\",\n    \"duration\" : 26,\n    \"width\" : 320,\n    \"height\" : 240\n  }, {\n    \"id\" : \"4\",\n    \"presetId\" : \"1351620000001-000010\",\n    \"key\" : \"JLQavt8PylmckTMS1351620000001000010.mp4\",\n    \"thumbnailPattern\" : \"JLQavt8PylmckTMS1351620000001000010-{count}\",\n    \"status\" : \"Complete\",\n    \"duration\" : 26,\n    \"width\" : 320,\n    \"height\" : 240\n  }, {\n    \"id\" : \"5\",\n    \"presetId\" : \"1351620000001-000001\",\n    \"key\" : \"JLQavt8PylmckTMS1351620000001000001.mp4\",\n    \"thumbnailPattern\" : \"JLQavt8PylmckTMS1351620000001000001-{count}\",\n    \"status\" : \"Complete\",\n    \"duration\" : 26,\n    \"width\" : 320,\n    \"height\" : 240\n  }, {\n    \"id\" : \"6\",\n    \"presetId\" : \"1351620000001-100070\",\n    \"key\" : \"JLQavt8PylmckTMS1351620000001100070.mp4\",\n    \"thumbnailPattern\" : \"JLQavt8PylmckTMS1351620000001100070-{count}\",\n    \"status\" : \"Complete\",\n    \"duration\" : 26,\n    \"width\" : 320,\n    \"height\" : 240\n  } ]\n}",
  "Timestamp" : "2015-01-09T09:33:46.189Z",
  "SignatureVersion" : "1",
  "Signature" : "iojsQVEE7K4jfCObVR4O5+0Fg8YQ/vlwL3WvT4lavACcveU3h7M3BlZ42cXF1t3hSazLKg8JZN465Gd4B40CDqssQNRLykr+U+O7oYuxQ+iPxFVuEVBLBBX63TjkJAyHS69il2OkC0C7Zrj8dfLqbVku1yMoOYKf9xUvXsS9qW+A29iYw5FJqDLnQJriWXLqv8qE3WKRbnCpVxG0LY/68NXY9hmi0XzScOzNIRn3fnhzFi2bvxDmJWy2+lA/am9nPGIy0sCrFvup2sp0jSUIg9i8TQieJBhcS8Ng/QyateRZZl5i2/qSuj79rvHC8OP6fQxnkB2Yn5BFhgmn/+sweg==",
  "SigningCertURL" : "https://sns.us-east-1.amazonaws.com/SimpleNotificationService-d6d679a1d18e95c2f9ffcf11f4f9e198.pem",
  "UnsubscribeURL" : "https://sns.us-east-1.amazonaws.com/?Action=Unsubscribe&SubscriptionArn=arn:aws:sns:us-east-1:932188653619:TranscodeTopic:0c4fb94e-3745-46b3-b75d-86f024f62f00"
} ';

    /*echo '<pre>';
    print_r(json_decode($json, true));
    echo '</pre>';
    die;*/
    $data =  json_decode(json_decode($json, true)['Message'],true);



    echo '<pre>';
    print_r($data['outputs']);
    echo '</pre>';
    die;
});

