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
Route::get('courseditor', 'SiteController@courseditor');
Route::get('crud', 'SiteController@crud');
Route::get('enroll', 'SiteController@enroll');
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
    Route::get('affiliate-agencies/affiliates/{id}', 'AffiliateAgenciesController@affiliates');
    Route::resource('affiliate-agencies', 'AffiliateAgenciesController');
});

// Course Categories
Route::get('coursecategories/subcategories', 'CoursesCategoriesController@subcategories');
Route::group(['prefix' => 'administration'], function (){
    Route::post('coursecategories/graphics_url/{category}', 'CoursesCategoriesController@graphics_url');
    Route::resource('coursecategories', 'CoursesCategoriesController');
    Route::resource('coursesubcategories', 'CoursesSubcategoriesController');
});

// Students
Route::group(['prefix' => 'student'], function (){
    Route::get('mycourses', 'StudentController@mycourses');
    Route::get('wishlist', 'StudentController@wishlist');
    Route::get('{email}/wishlist', 'StudentController@wishlist');
});

//Conversations
Route::get('conversations/lesson/{course}/{module}/{slug}', 'ConversationsController@lesson');
Route::get('conversations/replies/{id}/{skip}', 'ConversationsController@replies');
Route::get('conversations/replies/{id}', 'ConversationsController@replies');
Route::get('conversations/view-replies/{id}', 'ConversationsController@viewReplies');
Route::get('conversations/reply-to/{id}', 'ConversationsController@replyTo');
Route::post('conversations/load-more/', 'ConversationsController@loadMore');
Route::resource('conversations', 'ConversationsController');
//Wishlist
Route::resource('wishlist', 'WishlistController');
// Follow relationships
Route::resource('followers', 'FollowersController');
// Testimonials
Route::post('testimonials/more', 'TestimonialsController@more');
Route::post('testimonials/rate', 'TestimonialsController@rate');
Route::resource('testimonials', 'TestimonialsController');


// classroom
Route::get('classroom/{slug}/dashboard', 'ClassroomController@dashboard');
Route::get('classroom/{slug}/testimonial', 'ClassroomController@testimonial');
Route::get('classroom/{course}/{module}/{lesson}', 'ClassroomController@lesson');
Route::get('classroom/{slug}/', 'ClassroomController@dashboard');

// Courses Controller
Route::get('courses/mycourses', 'CoursesController@myCourses');
Route::get('courses/categories', 'CoursesController@categories');
Route::get('courses/category/{slug}/{subcat}', 'CoursesController@subCategory');
Route::get('courses/category/{slug}', 'CoursesController@category');
Route::post('courses/{slug}/purchase/{lesson}', 'CoursesController@purchaseLesson');
Route::post('courses/{slug}/purchase', 'CoursesController@purchase');
Route::get('courses/{slug}/curriculum', 'CoursesController@curriculum');

Route::resource('courses', 'CoursesController');
// Modules routes
Route::resource('courses.modules', 'ModulesController');

// Lessons
Route::get('modules/{module}/lessons/{id}/details', 'LessonsController@details');
Route::resource('modules.lessons', 'LessonsController');

// Blocks
Route::group(['prefix' => 'lessons'], function (){
    Route::group(['prefix' => 'blocks'], function (){
        Route::get('/{lesson_id}/text', 'BlocksController@text');
        Route::post('/{lesson_id}/{block_id}/text', 'BlocksController@saveText');
        Route::get('/{lesson_id}/files', 'BlocksController@files');
        Route::post('/{lesson_id}/files', 'BlocksController@uploadFiles');
        Route::delete('/{lesson_id}/{id}', 'BlocksController@destroy');
        Route::put('/{lesson_id}/{id}', 'BlocksController@update');
        Route::get('/{lesson_id}/video', 'BlocksController@video');
        Route::post('{lesson_id}/video', 'BlocksController@saveVideo');
        Route::post('{lesson_id}/video/assign', 'BlocksController@assignVideo');
    });
});
 
// Instructors routes
Route::get('instructors', 'InstructorsController@index');
Route::get('instructors/start/{user}', 'InstructorsController@start');
Route::get('instructors/become-instructor', 'InstructorsController@become');
Route::post('instructors/become-instructor', 'InstructorsController@doBecome');
Route::resource('instructors', 'InstructorsController');

//joke route
Route::get('shop', 'SiteController@shop');

## Route Group for Profile
Route::group(['prefix' => 'profile'], function (){
    ## Profile Page /profile
    Route::get('/{type?}', 'ProfileController@index');
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
    Route::post('sns/callback', 'SnsController@snsCallback');
    Route::get('{id}/json','VideosController@videoAndFormatsJson');
    Route::get('user/archive','VideosController@userArchive');
});


## Affiliate Dashboard Group
Route::group(['prefix' => 'dashboard'], function (){
    Route::get('/', 'AffiliateDashboardController@index');
    Route::get('topcourses/{frequency}/{courseId?}', 'AffiliateDashboardController@topCoursesView');
    Route::get('sales/{frequency}/{courseId?}', 'AffiliateDashboardController@salesView');
    Route::get('trackingcodessales/{frequency}/{courseId?}','AffiliateDashboardController@trackingCodesSalesView');
    Route::get('courseconversions/{frequency}/{courseId?}','AffiliateDashboardController@courseConversionView');
    Route::get('trackingcodeconversions/{frequency}/{courseId?}','AffiliateDashboardController@trackingCodeConversionView');
    Route::get('trackingcodehitssales/{frequency}/{courseId}/{code}','AffiliateDashboardController@trackingCodeHitsSalesView');
    Route::get('course/{id}/stats', 'AffiliateDashboardController@courseStatistics');
    Route::get('course/{id}/trackingcode/{code}/stats', 'AffiliateDashboardController@courseTrackingCodesStatistics');
    Route::get('course/{id}/trackingcode/{code}/stats/{frequency}','AffiliateDashboardController@trackingCodeHitsSalesView');
    Route::get('trackingcode/{code}/stats', 'AffiliateDashboardController@trackingCodeStatistics');
    Route::post('course/{courseId}/stats/compare','AffiliateDashboardController@compareCourses');
});

Route::get('test/pay', 'PaymentTestController@pay');

Route::get('test', function (){



    $url = "HTTPS://ps.gcsip.nl/wdl/wdl";
    //$data = "MERCHANTID=9950&ORDERID=12345678&EFFORTID=1&ATTEMPTID=1&PAYMENTREFERENCE=0&ADDITIONALREFERENCE=1234567890&PAYMENTMETHODID=1&PAYMENTPRODUCTID=3&STATUSID=625&STATUSDATE=20120314144539&RECEIVEDDATE=20120314144334&CURRENCYCODE=EUR&AMOUNT=1000&CVVRESULT=0&FRAUDRESULT=A&CCLASTFOURDIGITS=1111&EXPIRYDATE=0113";
    $data = '<XML>
    <REQUEST>
        <ACTION>INSERT_ORDERWITHPAYMENT</ACTION>
        <META>
            <MERCHANTID>9950</MERCHANTID>
            <IPADDRESS>180.191.81.9</IPADDRESS>
            <VERSION>2.0</VERSION>
        </META>
        <PARAMS>
            <ORDER>
                <ORDERID>234</ORDERID>
                <AMOUNT>100</AMOUNT>
                <CURRENCYCODE>JPY</CURRENCYCODE>
                <LANGUAGECODE>ja</LANGUAGECODE>
                <COUNTRYCODE>JP</COUNTRYCODE>
                <SURNAME>Cruijff</SURNAME>
                <CITY>Barcelona</CITY>
                <FIRSTNAME>Johan</FIRSTNAME>
                <STREET>Nou Camp</STREET>
                <HOUSENUMBER>14</HOUSENUMBER>
                <ZIP>1000 AA</ZIP>
                <STATE>Catalunie</STATE>
                <STATECODE>NL-NH</STATECODE>
                <SHIPPINGCITY>TOKYO</SHIPPINGCITY>
                <SHIPPINGCOUNTRYCODE>LA</SHIPPINGCOUNTRYCODE>
                <IPADDRESSCUSTOMER>201.11.13.19</IPADDRESSCUSTOMER>
                <EMAIL>test@yahoo.com</EMAIL>
                <MERCHANTREFERENCE>INVOICE123456873</MERCHANTREFERENCE>
            </ORDER>
            <PAYMENT>
                <PAYMENTPRODUCTID>1</PAYMENTPRODUCTID>
                <AMOUNT>100</AMOUNT>
                <CREDITCARDNUMBER>4263982640269299</CREDITCARDNUMBER>
                <EXPIRYDATE>0218</EXPIRYDATE>
                <CURRENCYCODE>JPY</CURRENCYCODE>
                <COUNTRYCODE>JP</COUNTRYCODE>
                <LANGUAGECODE>ja</LANGUAGECODE>
            </PAYMENT>
        </PARAMS>
    </REQUEST>
</XML>';
    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);

    $request = simplexml_load_string($result);

    echo '<pre>';
    print_r($request->REQUEST->RESPONSE);
    echo '</pre>';
    die;
});
