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
    if( Input::has('set-locale' )){
        Session::put('locale', Input::get('set-locale') );
    }
    if( Input::has('quick-peek-m8' )){
        Session::put('quick-peek-m8', 1 );
    }
    
    App::setLocale( Session::get('locale', Config::get('app.locale') ) );
    /** temporary mobile-desktop switcher **/
    if(Input::has('force-mobile')) Cookie::queue('force-mobile', 1, 60*24*30);
    if(Input::has('force-desktop')){
        Cookie::queue('force-desktop', 1, 60*24*30);
        Cookie::queue("force-mobile", null, -1);
    }
    
    if(Auth::guest() && Input::has('stpi')){
        Cookie::queue('stpi', Input::get('stpi'), 60*24*30);
    }
    if(Auth::guest() && Input::has('stpi2')){
        Cookie::queue('stpi2', Input::get('stpi2'), 60*24*30);
    }
    // record instructor agency
    if(Auth::guest() && Input::has('iai')){
        Cookie::queue('iai', Input::get('iai'), 60*24*30);
    }
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
  if ( Auth::check()){
      $ckname=Auth::getRecallerName(); //Get the name of the cookie, where remember me expiration time is stored
      $ckval=Cookie::get($ckname); //Get the value of the cookie
      return $response->withCookie(Cookie::make($ckname,$ckval, 60 * 24 * 30 )); //change the expiration time
  }
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
	if (Auth::check()) return Redirect::action('SiteController@index');
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
        if( !admin() ){
            if(Auth::guest()) return Redirect::guest( action('UsersController@login') );
            if(!Auth::user()->hasRole('Instructor')) return Redirect::action('SiteController@index');
        }
});

Route::filter('affiliate', function(){
    if(Auth::guest()) return Redirect::guest( action('AffiliateController@login') );
    if(!Auth::user()->hasRole('Affiliate')) return Redirect::action('SiteController@index');
});

Route::filter('nonInstructor', function(){
        if( !admin() ){
                if(Auth::check() && Auth::user()->hasRole('Instructor')) return Redirect::action('SiteController@index');
        }
});

Route::filter('forceHttps', function($req){
    if (! Request::secure()) {
        return Redirect::secure(Request::getRequestUri());
    }
});

Route::filter('verifiedLogin', function(){
    if( !Session::has( 'verifiedLogin' ) ){
        Session::set( 'url.intended', Request::url() );
        return Redirect::action( 'UsersController@confirmPassword' );
    }
});

Route::filter('logCourseView', function($request){
    $viewed_course_data = array();

    if(Auth::guest()){
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }

        $viewed_course_data['user_id'] = $_SERVER['REMOTE_ADDR'];
        
    } else {
        $user = Auth::user();
        $viewed_course_data['user_id'] = $user->id;
    }

    $user_logged = CourseLog::where('user_id', $viewed_course_data['user_id'])->first();
    $course = Course::where('slug', $request->getParameter('slug'))->first();
    if($course==null) return;
    $current_viewer = (Session::has('current_viewer'))? Session::get('current_viewer') : array( $viewed_course_data['user_id'] => array() ) ;

    $courses_viewed_today = (array_key_exists($viewed_course_data['user_id'], $current_viewer) && count($current_viewer[$viewed_course_data['user_id']]) >= 1)? $current_viewer[$viewed_course_data['user_id']] : array() ;
    
    if(!in_array($course->id, $courses_viewed_today)){
        $courses_viewed_today[] = $course->id;
    }
    
    $current_viewer[$viewed_course_data['user_id']] = $courses_viewed_today;

    Session::set('current_viewer', $current_viewer);

    if($user_logged){ //user has already been logged viewing courses
        $courses_viewed = json_decode($user_logged->courses_viewed);
        foreach($courses_viewed_today as $courses_viewed_tday){
            if(!in_array($courses_viewed_tday, $courses_viewed)){
                $courses_viewed[] = $courses_viewed_tday;
            }
        }
        $user_logged->courses_viewed = json_encode($courses_viewed);
        $user_logged->save();
    } else { // new user to be logged viewing courses
        $viewed_course_data['courses_viewed'] = json_encode($courses_viewed_today);
        CourseLog::create($viewed_course_data);
    }

});


Route::filter('restrictBrowsing', function($request){
    if( !Session::has('quick-peek-m8') ){
        $env = [ 'staging', 'production'];
        if( in_array( App::environment(), $env ) && 
               ( (Config::get('custom.restrict-browsing')==true && Auth::check() && !Auth::user()->hasRole('Admin') ) || Auth::guest() ) ){
            return Redirect::action('SiteController@index');
        }
    }
});