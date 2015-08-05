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
            
            if( $course==null || ( 
                    !$student->purchased( $course ) && 
                    !$student->purchasedLessonFromCourse( $course ) &&
                    $course->instructor_id != Auth::user()->id &&
                    $course->assigned_instructor_id != Auth::user()->id                     
                    ) 
                    ){
                return Redirect::to('/');
            }
            $nextLesson = $video = $student->nextLesson($course);
            
            $currentLesson = $student->currentLesson($course);
            if( $video ) $video = $video->blocks()->where('type','video')->first();
//            $video = $course->videoBlocks();
//            if($video!=null) $video = $video->first();
            $gift = $student->purchases()->where('product_id', $course->id)->where('product_type','course')->first();
            if( $gift != null ) $gift = $gift->gift;
            
            $instructor = $course->instructor;
            if($course->assigned_instructor_id > 0) $instructor = $course->assignedInstructor;
            if(Request::ajax()){
                return View::make('courses.classroom.course_comments_ajax')->with( compact('course') );
            }
            //return View::make('courses.classroom.dashboard')->with( compact('course', 'student', 'video', 'nextLesson', 'currentLesson', 'gift', 'instructor') );
            return View::make('courses.classroom.new.index',compact('course', 'student', 'video', 'nextLesson', 'currentLesson', 'gift', 'instructor') );
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
            if( $video != null ) $video = Video::find( $video->content );
//            if( !$student->purchased( $course ) && !$student->purchased( $lesson ) ){
            $purchase = $student->purchases()->where('product_type','Lesson')->where('product_id', $lesson->id)->first();
            if( $lesson==null || !$student->purchased($course) && $purchase==null && $lesson->free_preview == 'no' ){
                return Redirect::to('/');
            }
            if($student->id != $course->instructor_id && $student->id != $course->assigned_instructor_id ){
                if( (!$student->purchased($course) && $purchase==null && $lesson->free_preview=='yes') || ( !$student->purchased($course) && $purchase!=null && $purchase->free_product=='yes') ){
                    return View::make('courses.classroom.crash_lesson')->with( compact('course') )->with( compact('lesson') )->with( compact('video') );
                }
            }
            
            // if subscription, see if valid
            if($course->payment_type=='subscription'){
//                if( !in_array($lesson->module->id, $student->subscriptionModules($course)->lists('id'))){
                if( !$student->isLessonSubscribedTo( $lesson ) ){
                    return Redirect::to('/');
                }
            }
            
            $lesson->comments = $lesson->comments()->orderBy('id','desc')->where('reply_to', null)->with('poster')->paginate( 2 );
            if( $lesson==null || $lesson->module->course->id != $course->id ){
                return Redirect::to('/');
            }            
            $student->viewLesson( $lesson );
            if( $video==null ) $student->viewLesson( $lesson, true );
            
            $lesson->ask_teacher_messages = $lesson->privateMessages()->where('type','ask_teacher')->where(function($query){
                $query->where('sender_id', Auth::user()->id)->orWhere('recipient_id', Auth::user()->id);
            })->orderBy('id','desc')->paginate( 2 );
            
            $nextLesson = $lesson->next();
            $prevLesson = $lesson->prev();
            $currentLesson = $student->currentLesson($course);
            
            $instructor = $course->instructor;
            if($course->assigned_instructor_id > 0) $instructor = $course->assignedInstructor;
            $student->load('viewedLessons');
            
            if(Request::ajax()){
                $json['status'] = 'success';
                $json['html'] =  View::make('courses.classroom.lesson-ajax')->with( compact('course', 'lesson', 'video', 'nextLesson', 'prevLesson', 'currentLesson',
                        'instructor', 'student') )->render();
                return View::make('courses.classroom.lesson-ajax')->with( compact('course', 'lesson', 'video', 'nextLesson', 'prevLesson', 'currentLesson',
                        'instructor', 'student') )->render();
                 return json_encode($json);
//                if( Input::has('ask') ) return View::make('courses.classroom.lesson_ask_ajax')->with( compact('lesson','student') );
//                else return View::make('courses.classroom.lesson_comments_ajax')->with( compact('lesson','student') );
            }
            else{ 
                if( Input::has('old') )
                    return View::make('courses.classroom.lesson-old')->with( compact('course', 'lesson', 'video', 'nextLesson', 'prevLesson', 'currentLesson',
                        'instructor', 'student') );
                else
                    return View::make('courses.classroom.lesson')->with( compact('course', 'lesson', 'video', 'nextLesson', 'prevLesson', 'currentLesson',
                        'instructor', 'student') );
            }
        }
        
        public function resource($id){
            $id = PseudoCrypt::unhash($id);
            $block = Block::find($id);
            if( $block==null ){
                if( Request::ajax() ) return json_encode( ['status' => 'error', 'errors' => '' ]);
                return Redirect::to('/?1');
            }
            
            $student = Student::find(Auth::user()->id);
            $course = $block->lesson->module->course;
            $lesson = $block->lesson;
            $purchase = $student->purchases()->where('product_type','Lesson')->where('product_id', $lesson->id)->first();
            
            if($student->id == $course->instructor_id || $student->id == $course->assigned_instructor_id){
                return Redirect::to( $block->presignedUrl() );
                header('location: '.$block->presignedUrl());
            }
            else{
                if( !$student->purchased($course) && $purchase==null && $lesson->price > 0 ){
                    if( Request::ajax() ) return json_encode( ['status' => 'error', 'errors' => '' ]);
                    return Redirect::to('/?1');
                }
                if( (!$student->purchased($course) && $purchase==null && $lesson->price==0) || ( !$student->purchased($course) && $purchase->free_product=='yes') ){
                    if( Request::ajax() ) return json_encode( ['status' => 'error', 'errors' => '' ]);
                    return Redirect::to('/?2');
                }
                return Redirect::to( $block->presignedUrl() );
                header('location: '.$block->presignedUrl());
            }
        }
        
        public function completeLesson($id){
            $student = Student::find( Auth::user()->id );
            $lesson = Lesson::find($id);
            $student->viewLesson($lesson, true);
        }
        
        public function gift($id){
            $id = PseudoCrypt::unhash($id);
            $gift = GiftFile::find($id);
            if( $gift==null ){
                if( Request::ajax() ) return json_encode( ['status' => 'error', 'errors' => '' ]);
                return Redirect::to('/?3');
            }
            
            $student = Student::find(Auth::user()->id);
            
            if( !in_array($gift->gift_id, $student->purchases()->lists('gift_id') ) ){
                if( Request::ajax() ) return json_encode( ['status' => 'error', 'errors' => '' ]);
                return Redirect::to('/?4');
            }
            header('location: '.$gift->presignedUrl());
        }

}
