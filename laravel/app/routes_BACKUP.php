<?php //

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
//$domain = 'www.'.Config::get('app.base_url');
$domain = Config::get('app.base_url');
$instructorSubdomain = 'instructors.'.Config::get('app.base_url');
$affiliateSubdomain = 'affiliates.'. Config::get('app.base_url');

// workaround for codeception functional tests with subdomains
if( !isset($_SERVER['HTTP_HOST'])){
    $domain = $instructorSubdomain = $affiliateSubdomain = Request::getHost();
}
//Route::get('mandrill-test', 'SiteController@mandrillTest');

Route::resource('lp', 'LpController');
Route::get('loginTest', 'SiteController@loginTest');

Route::group( array('domain' =>  $domain), function(){
    // Site routes
    Route::get('/', 'SiteController@index');
	
    
    Route::get('/dash', 'SiteController@dashboard');

    // Temporary classroom route for mac to work with
    Route::get('courseditor', 'SiteController@courseditor');
    Route::get('crud', 'SiteController@crud');
    Route::get('enroll', 'SiteController@enroll');
    Route::get('classroom', 'SiteController@classroom');
    Route::get('admindash', 'SiteController@admindash');
    Route::get('affiliatedash', 'SiteController@affiliatedash');
    Route::get('classroomdash', 'SiteController@classroomdash');
    Route::get('classroom', 'SiteController@classroom');
	Route::get('courses/edit/step_1', 'SiteController@edit_description');
	Route::get('courses/edit/step_3', 'SiteController@edit_settings');

    // temporary tracking route
    Route::post('action-tracker', 'ActionController@track');

    // Confide routes
    Route::get('register', 'UsersController@create');
    Route::get('register/second-tier-publisher', 'UsersController@secondTierPublisherCreate');
    Route::get('links', 'UsersController@links');
    Route::get('register/account/{teacher_account}', 'UsersController@create');
    Route::post('users', 'UsersController@store');
    Route::get('login', 'UsersController@login');
    Route::get('fb-login/{userId?}', 'UsersController@fbLogin');
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
    Route::get('emailcheck', 'UsersController@emailCheck');
    Route::get('/registration-confirmation', 'UsersController@registrationConfirmation');
    Route::get('/verification-confirmation', 'UsersController@verificationConfirmation');


    // Admin Controller
    Route::group(array('prefix'=>'administration'),function(){
        Route::post('withdrawals/update', 'WithdrawalsController@update');
        Route::get('withdrawals/bank-file/{time}', 'WithdrawalsController@bankFile');
        Route::get('withdrawals/bank-file/', 'WithdrawalsController@bankFile');
        Route::post('withdrawals/bank-file/', 'WithdrawalsController@downloadBankFile');
        
        Route::resource('withdrawals', 'WithdrawalsController');
        Route::post('members/refund', 'MembersController@refund');
        Route::resource('members', 'MembersController');
        Route::resource('second-tier-publishers', 'SecondTierPublishersController');
        Route::resource('submissions', 'SubmissionsController');
        Route::get('instructor-agencies/instructors/{id}', 'InstructorAgenciesController@instructors');
        Route::resource('instructor-agencies', 'InstructorAgenciesController');
        Route::resource('frontpage-videos', 'FrontpageVideosController');
        Route::get('email/publishers', 'AdminEmailController@publishers');
        Route::post('email/publishers', 'AdminEmailController@sendPublishers');
    });

    // Course Categories
    Route::get('coursecategories/subcategories', 'CoursesCategoriesController@subcategories');
    Route::group(['prefix' => 'administration'], function (){
        Route::post('coursecategories/graphics_url/{category}', 'CoursesCategoriesController@graphics_url');
        Route::resource('coursecategories', 'CoursesCategoriesController');
        Route::resource('coursesubcategories', 'CoursesSubcategoriesController');
        Route::resource('course-difficulties', 'CourseDifficultiesController');
    });
});

// Affiliate promote links
Route::group( array('domain' => $instructorSubdomain ), function(){
    Route::group(['prefix' => 'affiliate'], function (){
        Route::get('promote/{course}', 'AffiliateController@promote');
        Route::post('gifts/{gift}/files', 'GiftsController@files');
        Route::resource('gifts', 'GiftsController');
        Route::resource('giftsfile', 'GiftsFileController');
    });
    
    Route::post('private-messages/massStore', 'PrivateMessagesController@massStore');
    Route::get('coursecategories/subcategories_instructor', 'CoursesCategoriesController@subcategories_instructor');

    Route::get('courses/search-instructor/{email}', 'CoursesController@searchInstructor');
    Route::get('courses/search-instructor/', 'CoursesController@searchInstructor');
});

Route::group( array('domain' => $domain ), function(){
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

    // Private Messages
    Route::get('private-messages/thread/{id}', 'PrivateMessagesController@thread');
    Route::resource('private-messages', 'PrivateMessagesController');
    //Wishlist
    Route::resource('wishlist', 'WishlistController');
    // Follow relationships
    Route::resource('followers', 'FollowersController');
    // Testimonials
    Route::post('testimonials/more', 'TestimonialsController@more');
    Route::post('testimonials/rate', 'TestimonialsController@rate');
    Route::resource('testimonials', 'TestimonialsController');


    // classroom
    Route::get('classroom/resource/{id}', 'ClassroomController@resource');
    Route::get('classroom/gift/{id}', 'ClassroomController@gift');
    Route::get('classroom/{slug}/dashboard', 'ClassroomController@dashboard');
    Route::get('classroom/{slug}/testimonial', 'ClassroomController@testimonial');
    Route::get('classroom/{course}/{module}/{lesson}', 'ClassroomController@lesson');
    Route::get('classroom/{slug}/', 'ClassroomController@dashboard');

    // Courses Controller
    Route::get('courses/mycourses', 'UsersController@login');
    Route::get('courses/view-discussion/{id}', 'CoursesController@viewDiscussion');
    Route::put('courses/{slug}/submit-for-approval', 'CoursesController@submitForApproval');
    Route::get('courses/search-instructor/{email}', 'CoursesController@searchInstructor');
    Route::get('courses/search-instructor/', 'CoursesController@searchInstructor');
    
    Route::get('courses/categories', 'CoursesController@categories');
    Route::get('courses/categories', 'CoursesController@categories');
    Route::get('courses/categories', 'CoursesController@categories');
    Route::get('courses/category/{slug}/{subcat}', 'CoursesController@subCategory');
    Route::get('courses/category/{slug}', 'CoursesController@category');
    Route::post('courses/{slug}/purchase/{lesson}', 'CoursesController@purchaseLesson');
    Route::post('courses/{slug}/crash/{lesson}', 'CoursesController@crashLesson');
    Route::post('courses/{slug}/crash/', 'CoursesController@crashCourse');
    Route::post('courses/{slug}/purchase', 'CoursesController@purchase');
    Route::get('courses/{slug}/purchased', 'CoursesController@purchased');

    Route::get('courses/{slug}', 'CoursesController@show');

});

Route::group( array('domain' => $instructorSubdomain ), function(){
    Route::get('courses/mycourses', 'CoursesController@myCourses');
    Route::get('courses/{slug}/curriculum', 'CoursesController@curriculum');
    Route::get('courses/{slug}/dashboard', 'CoursesController@dashboard');
    
    
    Route::post('courses/mark-resolved', 'CoursesController@markResolved');
    Route::post('courses/reply', 'CoursesController@reply');

    Route::resource('custompercentages', 'CustomPercentagesController');
    Route::get('courses/{slug}/custompercentage/', 'CoursesController@customPercentage');
    
    Route::get('courses/{slug}/edit/{step}', 'CoursesController@edit');
    
    Route::resource('courses', 'CoursesController');
    Route::get('courses/{slug}/custompercentage/', 'CoursesController@customPercentage');
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
});

Route::group( array('domain' => $domain ), function(){
    // Instructors routes
    Route::get('instructors', 'InstructorsController@index');
    Route::get('instructors/accept-terms', 'InstructorsController@acceptTerms');
    Route::post('instructors/accept-terms', 'InstructorsController@doAcceptTerms');
    Route::get('instructors/start/{user}', 'InstructorsController@start');
    Route::get('instructors/become-instructor', 'InstructorsController@become');
    Route::post('instructors/become-instructor', 'InstructorsController@doBecome');
    Route::resource('instructors', 'InstructorsController');

    //joke route
    Route::get('shop', 'SiteController@shop');
});

## Route Group for Profile

Route::group( array('domain' => $domain ), function(){
    Route::group(['prefix' => 'profile'], function (){
        Route::get('settings', 'ProfileController@settings');
        Route::put('settings', 'ProfileController@updateSettings');
        Route::get('finance', 'ProfileController@finance');

        ## Profile Page /profile
        Route::get('/{type?}', 'ProfileController@index');
        ## POST call to upload a profile picture
        Route::post('upload-profile-picture', 'ProfileController@uploadProfilePicture');
        ## POST call to process additional data for initial profile set-up
        Route::post('store-new-profile', 'ProfileController@storeNewProfile');
        ##
        Route::post('{id}/update', 'ProfileController@update');
    });
});


Route::group( array('domain' => $affiliateSubdomain ), function(){    
    Route::group(['prefix' => 'dashboard'], function (){
        Route::get('/','AffiliateDashboardController@index');
        Route::get('topcourses/{frequency}/{courseId?}', 'AffiliateDashboardController@topCoursesView');
        Route::get('sales/{frequency}/{courseId?}/{trackingCode?}', 'AffiliateDashboardController@salesView');
        Route::get('trackingcodessales/{frequency}/{courseId?}','AffiliateDashboardController@trackingCodesSalesView');
        Route::get('courseconversions/{frequency}/{courseId?}','AffiliateDashboardController@courseConversionView');
        Route::get('trackingcodeconversions/{frequency}/{courseId?}','AffiliateDashboardController@trackingCodeConversionView');
        Route::get('trackingcodehitssales/{frequency}/{courseId}/{code}','AffiliateDashboardController@trackingCodeHitsSalesView');
        Route::get('course/{id}/stats', 'AffiliateDashboardController@courseStatistics');
        Route::get('course/{id}/trackingcode/{code}/stats', 'AffiliateDashboardController@courseTrackingCodesStatistics');
        Route::get('course/{id}/trackingcode/{code}/stats/{frequency}','AffiliateDashboardController@trackingCodeHitsSalesView');
        Route::get('trackingcode/{code}/stats', 'AffiliateDashboardController@trackingCodeStatistics');
        Route::post('course/{courseId}/stats/compare','AffiliateDashboardController@compareCourses');
        Route::post('trackingcodes/{trackingCode}/stats/compare','AffiliateDashboardController@compareTrackingCodes');
        Route::get('trackingcodetable/{frequency}/{courseId}','AffiliateDashboardController@trackingCodesTableView');
        Route::get('trackingcodes/all', 'AffiliateDashboardController@trackingCodesAll');
        Route::get('ltcregistrations/{frequency}','AffiliateDashboardController@ltcRegistrationsView');
    });
});


//Had to put this outside of the domain classification

##Admin Dashboard Group



Route::group( array('domain' => $instructorSubdomain ), function(){
    ## Route Group Videos Manager
    Route::group(['prefix' => 'video'], function(){
        Route::get('add','VideosController@add');
        Route::post('upload', 'VideosController@doUpload');
        Route::post('add-by-filename','VideosController@addVideoByFilename');
        Route::any('sns/callback', 'SnsController@snsCallback');
        Route::get('{id}/json','VideosController@videoAndFormatsJson');
        Route::any('user/archive','VideosController@userArchive');
        Route::post('{id}/delete','VideosController@delete');
    });
});

##Dashboard Group

Route::group(['prefix' => 'dashboard'], function (){

    Route::get('/', 'AdminDashboardController@index');


    /***** AFFILIATE RELATED *****************************/

    Route::get('sales/{frequency}/{courseId?}/{trackingCode?}', 'AffiliateDashboardController@salesView');


    /******* SUPER ADMIN RELATED **************************/
    Route::get('users/count/{frequency?}','AdminDashboardController@userCountView');
    Route::get('admin/sales/count/{frequency?}','AdminDashboardController@salesCountView');
    Route::get('admin','AdminDashboardController@index');
    Route::any('admin/category/{categoryId}/{freeCourse}','AdminDashboardController@topCoursesByCategory');
    Route::any('admin/affiliatestable','AdminDashboardController@topAffiliatesTableView');
    Route::any('admin/courses/{freeCourse}','AdminDashboardController@topCoursesTableView');
});


## Payment Form(https)
Route::group(['prefix' => 'payment'], function (){
    Route::get('/','PaymentController@index');
    Route::post('/','PaymentController@process');
    Route::get('callback/{reference}','PaymentController@paymentReturn');
    Route::get('do-payment/{reference}','PaymentController@renderGCForm');
});


## API Routes
Route::group(['prefix' => 'api'], function(){
    Route::group(['prefix' => 'payment'], function(){
        Route::post('creditcard','ApiPaymentController@creditCard');
        Route::post('profile/create','ApiPaymentController@createProfile');
        Route::post('order/status','ApiPaymentController@getOrderStatus');
    });
    Route::post('profile/invalidate','ApiPaymentController@invalidateToken');
});

Route::post('courses/{id}/video/set-description','CoursesController@setVideoDescription');

Route::get('test', function(){


    $users = [
        ['firstName' => 'Albert', 'lastName' => 'Maranian', 'email' => 'albert1@gmail.com'],
        ['firstName' => 'Albert', 'lastName' => 'Maranian', 'email' => 'albert2@gmail.com'],
        ['firstName' => 'Albert', 'lastName' => 'Maranian', 'email' => 'albert3@gmail.com'],
        ['firstName' => 'Albert', 'lastName' => 'Maranian', 'email' => 'albert4@gmail.com']
    ];
    $usersJson = json_encode($users);
    $delHelper = new DeliveredHelper();

    $result = $delHelper->getUsers();

    echo '<pre>';
    print_r($result);
    echo '</pre>';
    die;
});


Route::get('payment-test', 'PaymentTestController@pay');