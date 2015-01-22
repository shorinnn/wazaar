<?php

class StudentController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth' );
        }

	public function mycourses()
	{    
            $student = Student::find( Auth::user()->id );
            $purchases = $student->purchases;
            return View::make('student.mycourses')->with( compact('purchases') );
	}
        
        
        public function wishlist(){
            $student = Student::find( Auth::user()->id );
            $wishlist = $student->wishlistItems()->get();
            return View::make('student.wishlist')->with( compact('wishlist') );
        }
}
