<?php

class ClassroomController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth' );
        }
        
        public function dashboard($slug){
            $course = Course::where('slug', $slug)->with(['modules.lessons' => function($query){
                                $query->orderBy('order','ASC');
                                $query->where('published','yes');
                            }])
                             ->with(['modules' => function($query){
                                $query->orderBy('order','ASC');
                            }])
                            ->first();
                            
            $student = Student::find( Auth::user()->id );
            if( $course==null || !$student->purchased( $course ) ){
                return Redirect::to('/');
            }
            return View::make('courses.classroom.dashboard')->with( compact('course') )->with( compact('student') );
        }
        
        public function lesson($course, $lesson){
            $course = Course::where('slug', $course)->first();
            $student = Student::find( Auth::user()->id );
            if( $course==null || !$student->purchased( $course ) ){
                return Redirect::to('/');
            }
            $lesson = Lesson::where('slug', $lesson)->with('blocks')->with('comments.replies')
                    ->with('comments.poster')->with(['comments' => function($query){
                        $query->limit(2);
                        $query->where('reply_to',null);
                        $query->orderBy('id','desc');
                        
                    }])->first();
                    
            if( $lesson==null || $lesson->module->course->id != $course->id ){
                return Redirect::to('/');
            }            
            $student->viewLesson( $lesson );
            return View::make('courses.classroom.lesson')->with( compact('course') )->with( compact('lesson') );
        }

}
