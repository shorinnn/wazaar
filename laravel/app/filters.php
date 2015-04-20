<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    // record the LTC Affiliate on any page
    if(Auth::guest() && Input::has('aid')){
        Cookie::queue('ltc', Input::get('aid'), 60*24*30);

		if(Input::has('tcode')){ //if a GET tcode param is found
			$storeTCodeCooke = false;
			if (Cookie::has('tcode') && Cookie::get('tcode') !== Input::get('tcode')){ //we flag storing of tcode if an existing cookie is found but doesn't match GET param
				$storeTCodeCooke = true;
			}

			if (!$storeTCodeCooke AND !Cookie::has('tcode')){ //above said that we don't store, but no cookie yet, so flag to store
				$storeTCodeCooke = true;
			}

			if ($storeTCodeCooke){
				Cookie::queue('tcode', Input::get('tcode'), 60*24*30);
				//store this as hit
				$courseId = 0;
				if (Request::segment(1) == 'courses' AND Request::segment(2)){
					$course = Course::where('slug', Request::segment(2))->first();
					if ($course){
						$courseId = $course->id;
					}
				}

				TrackingCodeHits::create([
					'tracking_code' => Input::get('tcode'),
					'affiliate_id'  => Input::get('aid'),
					'course_id' => $courseId
				]);
			}

		}
    }


});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest( action('UsersController@login') );
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
    if(App::environment()=="testing" || App::environment()=="codeception") return;
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('admin', function()
{
	if (Auth::guest()) return Redirect::action('SiteController@index');
        if(!Auth::user()->hasRole('Admin')) return Redirect::action('SiteController@index');
});

Route::filter('instructor', function(){
        if(Auth::guest()) return Redirect::guest( action('UsersController@login') );
        if(!Auth::user()->hasRole('Instructor')) return Redirect::action('SiteController@index');
});

Route::filter('affiliate', function(){
    if(Auth::guest()) return Redirect::guest( action('UsersController@login') );
    if(!Auth::user()->hasRole('Affiliate')) return Redirect::action('SiteController@index');
});

Route::filter('nonInstructor', function()
{
        if(Auth::check() && Auth::user()->hasRole('Instructor')) return Redirect::action('SiteController@index');
});