<?php

class PrivateMessagesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('auth');
            $this->beforeFilter( 'csrf', ['only' => [ 'store', 'update', 'destroy' ]] );
        }

        public function index(){
            $student = Student::find( Auth::user()->id );
            $messages = $student->receivedMessages()->orderBy('id','desc')->paginate( 2 );
            if( Request::ajax() ) return View::make('private_messages.partials.inbox_list')->with( compact('messages') );
            else return View::make('private_messages.index')->with( compact('messages') );
        }
        
        public function thread($id){
            $message = PrivateMessage::find($id);
            $messages = PrivateMessage::where('id', '<=', $id)->where(function($query) use($message, $id){
                if($message->thread_id > 0){
                  $query->where('id',$id)->orWhere('thread_id',$message->thread_id)->orWhere('id',$message->thread_id)  ;
                }
                else{
                  $query->where('id',$id) ;
                }
            })->orderBy('id','desc')->paginate( 2 );
            
            return View::make('private_messages.partials.all_inbox')->withComments( $messages )->with( compact('id') );
        }
        
	public function store()
	{
            $student = Student::find( Auth::user()->id );
            
            $pm = new PrivateMessage([ 'sender_id' => Auth::user()->id, 'content' => Input::get('content'), 'type' => Input::get('type') ]);
            $pm->type = Input::get('type');
            if(Input::get('type')=='ask_teacher'){
                $lesson = Lesson::find( Input::get('lesson_id') );
                $course = Course::find( Input::get('course_id') );
                if( $course->instructor->id != Auth::user()->id && !$student->purchased($course) && !$student->purchased( $lesson ) ){
                     return Redirect::to('/');
                }
                $pm->course_id = Input::get('course_id');
                $pm->lesson_id = Input::get('lesson_id');
                if($course->instructor->id == Auth::user()->id){
                    $msg = PrivateMessage::find(Input::get('thread_id'));
                    if($msg){
                        if($msg->sender_id != Input::get('recipient_id') ) $pm->recipient_id = $msg->sender_id;
                        else $pm->recipient_id = $msg->recipient_id;
                    }
                }
                else{
                    $pm->recipient_id = $course->instructor->id;
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
            else{}
            
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

	/**
	 * Display the specified resource.
	 * GET /privatemessages/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /privatemessages/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /privatemessages/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /privatemessages/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}