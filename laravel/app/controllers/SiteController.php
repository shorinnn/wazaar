<?php

class SiteController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth', [ 'only' => ['dashboard'] ] );
        }

	public function index()
	{         
            if(Input::has('skip-the-splashie')){
//                $frontpageVideos  = FrontpageVideo::grid();
                $categories = CourseCategory::limit(12);
                
                if ( !Cache::has('topCourses') ){
                    $top = HomepageHelper::generateVariations(8);
                    Cache::add('topCourses', $top, 30);
                }
                
                $topCourses = Cache::get('topCourses');
                $topCourses = $topCourses[ rand(0, count($topCourses)-1 ) ];
                
                if(Auth::user()) Return View::make('site.homepage_authenticated')->with(compact('categories'));
                else{
                    if(Input::has('old-page'))
                        Return View::make('site.homepage_unauthenticated_DEPR')->with( compact('categories', 'frontpageVideos', 'topCourses') );
                    else
                        Return View::make('site.homepage_unauthenticated')->with( compact('categories', 'frontpageVideos', 'topCourses') );
                }
            }
            if( Auth::check() ){
                if( Auth::user()->is_second_tier_instructor == 'yes' ) return Redirect::action('UsersController@links');
                if( Auth::user()->hasRole('Instructor') ) return Redirect::action('CoursesController@myCourses');
            }
            return View::make('splash');
	}

        
	public function dashboard()
	{                 
            $student = Student::find( Auth::user()->id );
            $transactions = $student->transactions->orderBy('id','desc')->paginate(2);
            return View::make('site.dashboard')->with( compact('student', 'transactions') );
	}

	public function edit_description()
	{                 
            return View::make('courses.edit_course_description');
	}

	public function checkout()
	{                 
            return View::make('courses.checkout');
	}

	public function edit_settings()
	{                 
            return View::make('courses.edit_course_settings');
	}
        
	public function classroom()
	{            
            Return View::make('site.classroom');
	}
        
        public function crud(){
             Return View::make('TEMPORARYVIEWS.crud');
        }
        
        public function admindash(){
             Return View::make('TEMPORARYVIEWS.questions');
             	//Return View::make('confide.account_details');
            	 //Return View::make('TEMPORARYVIEWS.admin_dashboard');
        }
        
        public function affiliatedash(){
             Return View::make('TEMPORARYVIEWS.affiliate_dashboard');
        }
        
        public function classroomdash(){
             Return View::make('TEMPORARYVIEWS.classroom_dashboard');
        }
        
        public function enroll(){
             Return View::make('TEMPORARYVIEWS.enroll');
        }
        
        public function shop(){
             Return View::make('TEMPORARYVIEWS.shop');
        }

        public function courseditor(){
             Return View::make('TEMPORARYVIEWS.course_editor');
        }
        
//        public function mandrillTest(){
//            Config::set('app.debug', true);
//            $user = User::where('email', 'sorincoder25@mailinator.com')->first();
//            try{
//                if (Config::get('confide::signup_email')) {
//                    Mail::send(
//                        Config::get('confide::email_account_confirmation'),
//                        compact('user'),
//                        function ($message) use ($user) {
//                            $message
//                                ->to($user->email, $user->usersname)
//                                ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
//                        }
//                    );
//                    
//                }
//                else{
//                    echo 'no mandrill!';
//                }
//            }
//            catch(Exception $e){
//                dd( $e->getMessage() );
//            }
//            
//            dd($user);
//        }


    public function loginTest(){
        $user = User::find(60);
        $user = User::find(74);
        Auth::login($user);
    }
}
