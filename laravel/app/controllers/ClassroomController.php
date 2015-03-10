<?php

class ClassroomController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth' );
        }
        
        public function dashboard($slug){
            $student = Student::find( Auth::user()->id );
            $course = Course::where('slug', $slug)->with('modules.lessons.module')->with(['modules.lessons' => function($query){
                                $query->orderBy('order','ASC');
                                $query->where('published','yes');
                            }])
                             ->with(['modules' => function($query){
                                $query->orderBy('order','ASC');
                            }])
                            ->first();
            if($course->payment_type=='subscription'){
                    $course->modules = $student->subscriptionModules($course)->get();
                }
            $course->comments = $course->comments()->orderBy('id','desc')->paginate( 2 );
            $unread = $student->receivedMessages()->unread( $student->id );
            $student->unreadAnswers = $unread->where('type','ask_teacher')->where('course_id', $course->id)->get();
            $unread = $student->receivedMessages()->unread( $student->id );
            $student->unreadAnnouncements = $unread->where('type','mass_message')->where('course_id', $course->id)->get();
            
            $student->announcements = $student->receivedMessages()->where('type','mass_message')->where('course_id', $course->id)->orderBy('id','desc')->get();
            $student->answers = $student->receivedMessages()->where('type','ask_teacher')->where('course_id', $course->id)->orderBy('id','desc')->get();
            
            if( $course==null || ( !$student->purchased( $course ) && !$student->purchasedLessonFromCourse( $course ) ) ){
                return Redirect::to('/');
            }
            $video = $student->nextLesson($course);
            if( $video ) $video = $video->blocks()->where('type','video')->first();
//            $video = $course->videoBlocks();
//            if($video!=null) $video = $video->first();
            if(Request::ajax()){
                return View::make('courses.classroom.course_comments_ajax')->with( compact('course') );
            }
            return View::make('courses.classroom.dashboard')->with( compact('course') )->with( compact('student') )->with( compact('video') );
        }
        
        public function testimonial($slug){
            $course = Course::where('slug', $slug)->first();
            $student = Student::find( Auth::user()->id );
            if( $course==null || !$student->purchased( $course ) ){
                return Redirect::to('/');
            }
            //TODO: additional rule for completion
            $testimonial = $student->testimonials()->where('course_id', $course->id)->first();
            if($testimonial==null) $testimonial = new Testimonial;
            return View::make('courses.testimonials.form')->with( compact('course') )
                    ->with( compact('student') )->with( compact('testimonial') );
        }
        
        public function lesson($course, $module, $lesson){
            $course = Course::where('slug', $course)->first();
            $student = Student::find( Auth::user()->id );
            if( $course==null  ){
                return Redirect::to('/');
            }
            $module = $course->modules()->where('slug', $module)->first();
            $lesson = $module->lessons()->where('slug', $lesson)->with('blocks')->first();
            $video = $lesson->blocks()->where('type','video')->first();
            if( !$student->purchased( $course ) && !$student->purchased( $lesson ) ){
                // load crash lesson mode if lesson is free
                if( $lesson->price==0 ){
                    return View::make('courses.classroom.crash_lesson')->with( compact('course') )->with( compact('lesson') )->with( compact('video') );
                }
                return Redirect::to('/');
            }
            // if subscription, see if valid
            if($course->payment_type=='subscription'){
//                if( !in_array($lesson->module->id, $student->subscriptionModules($course)->lists('id'))){
                if( $student->isLessonSubscribedTo( $lesson ) ){
                    return Redirect::to('/');
                }
            }
            
            $lesson->comments = $lesson->comments()->orderBy('id','desc')->where('reply_to', null)->with('poster')->paginate( 2 );
            if( $lesson==null || $lesson->module->course->id != $course->id ){
                return Redirect::to('/');
            }            
            $student->viewLesson( $lesson );
            
            $lesson->ask_teacher_messages = $lesson->privateMessages()->where('type','ask_teacher')->where(function($query){
                $query->where('sender_id', Auth::user()->id)->orWhere('recipient_id', Auth::user()->id);
            })->orderBy('id','desc')->paginate( 2 );
            
            
            if(Request::ajax()){
                if( Input::has('ask') ) return View::make('courses.classroom.lesson_ask_ajax')->with( compact('lesson') );
                else return View::make('courses.classroom.lesson_comments_ajax')->with( compact('lesson') );
            }
            else return View::make('courses.classroom.lesson')->with( compact('course') )->with( compact('lesson') )->with( compact('video') );
        }

}
