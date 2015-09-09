<?php

class InstructorsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'nonInstructor', ['only' => 'become'] );
            $this->beforeFilter( 'instructor', [ 'except' => ['start', 'become', 'doBecome'] ] );
        }

	public function index()
	{
            Return View::make('instructors/index');
	}
        
        public function start($user){
            Session::set( 'url.intended', action('InstructorsController@become') );
            if($user=='new-user'){
                return Redirect::to('register/instructor');
            }
            else{
                return Redirect::action('UsersController@login');
            }
        }
        
        public function become()
	{
            if( Auth::user()->hasRole('Affiliate') ) return Redirect::action('SiteController@index');
            $users = new UserRepository();
            $users->become( 'Instructor', Auth::user(), Cookie::get('stpi') );
            return Redirect::action('CoursesController@myCourses');
//            Return View::make('instructors/become');
	}
        
        public function doBecome(){
            $users = new UserRepository();
            if( $users->become( 'Instructor', Auth::user(), Cookie::get('stpi') ) ){
                return Redirect::action('CoursesController@myCourses');
                return Redirect::action('InstructorsController@index')->withSuccess( trans('instructors/general.congratulations_become_instructor') );
            }
            else{
                return Redirect::action('CoursesController@myCourses');
                return Redirect::action('InstructorsController@index')->withSuccess( trans('instructors/general.congratulations_become_instructor') );
//                return Redirect::action('InstructorsController@index')->withError( trans('instructors/general.already_instructor') );
            }
        }
        
        public function acceptTerms(){
            $i = Instructor::find( Auth::user()->id );
            return View::make('instructors.at');
//            return View::make('instructors.terms');
        }
        
        public function doAcceptTerms(){
            if( Input::get('accept') != 1 ) return View::make('instructors.at');
            Auth::user()->accepted_instructor_terms = 'yes';
            Auth::user()->updateUniques();
            return Redirect::action('CoursesController@myCourses');
        }
}
