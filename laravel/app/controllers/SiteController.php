<?php

class SiteController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth', [ 'only' => ['dashboard'] ] );
        }

	public function index()
	{         
            if(Input::has('skip-the-splashie')){
                $frontpageVideos  = FrontpageVideo::grid();
                $categories = CourseCategory::with('featuredCourse')->get();
                if(Auth::user()) Return View::make('site.homepage_authenticated')->with(compact('categories'));
                else Return View::make('site.homepage_unauthenticated')->with( compact('categories', 'frontpageVideos') );
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
        
        public function mandrillTest(){
            Config::set('app.debug', true);
            $user = User::where('email', 'sorincoder25@mailinator.com')->first();
            try{
                if (Config::get('confide::signup_email')) {
                    
                    dd($user);
                    Mail::send(
                        Config::get('confide::email_account_confirmation'),
                        compact('user'),
                        function ($message) use ($user) {
                            $message
                                ->to($user->email, $user->usersname)
                                ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                        }
                    );
                    if(count(Mail::failures()) > 0){
                        dd( Mail::failures() );
                    }
                }
                else{
                    echo 'no mandrill!';
                }
            }
            catch(Exception $e){
                dd($e);
            }
            
            dd($user);
        }



}
