<?php

class StudentController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth', ['except' => 'wishlist'] );
        }

	public function mycourses()
	{    
            $student = Student::find( Auth::user()->id );
            $student->load( 'viewedLessons.lesson' );
            $lastLesson = $student->viewedLessons()->orderBy('updated_at','desc')->first();
            if($lastLesson != null )            $lastLesson->load( 'lesson.module.course', 'lesson.module', 'lesson' );

            
            $courses = $student->purchases()->where('product_type','Course')->get();
            if( $courses != null ) $courses->load( 'product.modules.lessons', 'product.modules', 'product' );

            $wishlist = $student->wishlistItems;
            if($wishlist !=null )$wishlist->load('course');
            $profile = $student->profile;
            
            return View::make('student.mycourses')->with( compact('student', 'lastLesson', 'courses', 'wishlist', 'profile') );
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
