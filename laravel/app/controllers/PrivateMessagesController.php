<?php

class PrivateMessagesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('auth');
            $this->beforeFilter( 'csrf', ['only' => [ 'store', 'update', 'destroy' ]] );
        }

        public function index(){
            $student = Student::find( Auth::user()->id );
            $messages = $student->receivedMessages()->orderBy('id','desc')->paginate( 2 );
            if( Request::ajax() ) return View::make('private_messages.partials.inbox_list')->with( compact('messages', 'student') );
            else return View::make('private_messages.index')->with( compact('messages', 'student') );
        }
        
        public function thread($id){
            $student = Student::find( Auth::user()->id );
            $message = PrivateMessage::find($id);
            $messages = PrivateMessage::where('id', '<=', $id)->where(function($query) use($message, $id){
                if($message->thread_id > 0){
                  $query->where('id',$id)->orWhere('thread_id',$message->thread_id)->orWhere('id',$message->thread_id)  ;
                }
                else{
                  $query->where('id',$id) ;
                }
            })->orderBy('id','desc')->paginate( 2 );
            
            if( Request::ajax() ) return View::make('private_messages.partials.all_inbox')->withComments( $messages )->with( compact('id', 'student') );
            else return View::make('private_messages.thread')->withMessages( $messages )->with( compact('id', 'student') );
             
        }
        
        
	public function massStore()
	{
            $student = Student::find( Auth::user()->id );
            
            $pm = new PrivateMessage([ 'sender_id' => Auth::user()->id, 'content' => Input::get('content'), 'type' => Input::get('type') ]);
            $pm->type = Input::get('type');
            if(Input::get('type')=='ask_teacher'){
                $course = Course::find( Input::get('course_id') );
                $instructor = $course->instructor;
                if($course->assigned_instructor_id != null){
                    $instructor = $course->assignedInstructor;
                }
                $lesson = Lesson::find( Input::get('lesson_id') );
                if( $instructor->id != Auth::user()->id && !$student->purchased($course) && !$student->purchased( $lesson ) ){
                     return Redirect::to('/');
                }
                $pm->course_id = Input::get('course_id');
                $pm->lesson_id = Input::get('lesson_id');
                if($instructor->id == Auth::user()->id){
                    $msg = PrivateMessage::find(Input::get('thread_id'));
                    if($msg){
                        if($msg->sender_id != Input::get('recipient_id') ) $pm->recipient_id = $msg->sender_id;
                        else $pm->recipient_id = $msg->recipient_id;
                    }
                }
                else{
                    $pm->recipient_id = $instructor->id;
                }
            }
            elseif( Input::get('type')=='student_conversation'){
                if(Auth::user()->id == Input::get('recipient_id')){
                    $msg = PrivateMessage::find(Input::get('thread_id'));
                    if($msg){
                        if($msg->sender_id != Input::get('recipient_id') ) $pm->recipient_id = $msg->sender_id;
                        else $pm->recipient_id = $msg->recipient_id;
                    }
                }
                else $pm->recipient_id = Input::get('recipient_id');
            }
            else{
                $pm->course_id = Input::get('course_id');
            }
            
            $pm->thread_id = intval(Input::get('thread_id'));
            if( $pm->save() ){
                if( Request::ajax() ){
                    return json_encode( ['status'=>'success', 
                        'html' => View::make('private_messages.conversation')->withMessage( $pm )->render()  ]);
                }
                else{
                    return Redirect::back();
                }
            }
            else{
                if( Request::ajax() ){
                    return json_encode( ['status'=>'error', 'errors' => format_errors($pm->errors()->all()) ]);
                }
                else{
                    return Redirect::back()->withErrors( format_errors($pm->errors()->all()) );
                }
            }
	}
        
	public function store()
	{
            $student = Student::find( Auth::user()->id );
            
            $pm = new PrivateMessage([ 'sender_id' => Auth::user()->id, 'content' => Input::get('content'), 'type' => Input::get('type') ]);
            $pm->type = Input::get('type');
            if(Input::get('type')=='ask_teacher'){
                $course = Course::find( Input::get('course_id') );
                $instructor = $course->instructor;
                if($course->assigned_instructor_id != null){
                    $instructor = $course->assignedInstructor;
                }
                $lesson = Lesson::find( Input::get('lesson_id') );
                if( $instructor->id != Auth::user()->id && !$student->purchased($course) && !$student->purchased( $lesson ) ){
                     return Redirect::to('/');
                }
                $pm->course_id = Input::get('course_id');
                $pm->lesson_id = Input::get('lesson_id');
                if($instructor->id == Auth::user()->id){
                    $msg = PrivateMessage::find(Input::get('thread_id'));
                    if($msg){
                        if($msg->sender_id != Input::get('recipient_id') ) $pm->recipient_id = $msg->sender_id;
                        else $pm->recipient_id = $msg->recipient_id;
                    }
                }
                else{
                    $pm->recipient_id = $instructor->id;
                }
            }
            elseif( Input::get('type')=='student_conversation'){
                if(Auth::user()->id == Input::get('recipient_id')){
                    $msg = PrivateMessage::find(Input::get('thread_id'));
                    if($msg){
                        if($msg->sender_id != Input::get('recipient_id') ) $pm->recipient_id = $msg->sender_id;
                        else $pm->recipient_id = $msg->recipient_id;
                    }
                }
                else $pm->recipient_id = Input::get('recipient_id');
            }
            else{
                $pm->course_id = Input::get('course_id');
            }
            
            $pm->thread_id = intval(Input::get('thread_id'));
            if( $pm->save() ){
                if( Request::ajax() ){
                    return json_encode( ['status'=>'success', 
                        'html' => View::make('private_messages.conversation')->withMessage( $pm )->render()  ]);
                }
                else{
                    return Redirect::back();
                }
            }
            else{
                if( Request::ajax() ){
                    return json_encode( ['status'=>'error', 'errors' => format_errors($pm->errors()->all()) ]);
                }
                else{
                    return Redirect::back()->withErrors( format_errors($pm->errors()->all()) );
                }
            }
	}

}