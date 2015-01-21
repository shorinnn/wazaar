<?php

class ClassroomController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth' );
        }
        
        public function dashboard($slug){
            $course = Course::where('slug', $slug)->first();
            $student = Student::find( Auth::user()->id );
            if( $course==null || !$student->purchased( $course ) ){
                return Redirect::to('/');
            }
            return View::make('courses.classroom.dashboard')->with( compact('course') );
        }
        
        public function lesson($course, $lesson){
            $course = Course::where('slug', $course)->first();
            $student = Student::find( Auth::user()->id );
            if( $course==null || !$student->purchased( $course ) ){
                return Redirect::to('/');
            }
            $lesson = Lesson::where('slug', $lesson)->with('blocks')->first();
            if( $lesson==null || $lesson->module->course->id != $course->id ){
                return Redirect::to('/');
            }
            return View::make('courses.classroom.lesson')->with( compact('course') )->with( compact('lesson') );
        }

}
