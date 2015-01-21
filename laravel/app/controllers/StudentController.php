<?php

class StudentController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth' );
        }

	public function mycourses()
	{    
            $purchases = Student::find( Auth::user()->id )->purchases;
            return View::make('student.mycourses')->with( compact('purchases') );
	}
}
