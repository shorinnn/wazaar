<?php

class StudentController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth', ['except' => 'wishlist'] );
        }

	public function mycourses()
	{    
            $student = Student::find( Auth::user()->id );
            return View::make('student.mycourses')->with( compact('student') );
	}
        
        
        public function wishlist($email=''){
            if($email=='') $student = Student::find( Auth::user()->id );
            else $student = Student::where('email', $email)->first();
            if( $student==null ){
                return View::make('site.error_encountered');
            }
            $wishlist = $student->wishlistItems;
            return View::make('student.wishlist')->with( compact('wishlist') )->with( compact('student') );
        }
}
