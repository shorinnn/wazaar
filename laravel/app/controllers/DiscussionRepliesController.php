<?php

class DiscussionRepliesController extends \BaseController {

	public function store()
	{
            $discussion = LessonDiscussion::find( Input::get('lesson_discussion_id') );
            
            $student = Student::find( Auth::user()->id );
            $lesson = Lesson::find( $discussion->lesson_id );          
            $reply = new LessonDiscussionReply( Input::all() );
            $reply->student_id = Auth::user()->id;
            $course = $lesson->module->course;
            if( $reply->save() ){
                // update the discussion timestamp
                DB::table('lesson_discussions')->where('id', $discussion->id)->update( [ 'updated_at' => date('Y-m-d H:i:s') ] );
                  if( Request::ajax() ){
                    $response['status'] = 'success';
                    $response['html'] = View::make('courses.classroom.discussions.reply')->with( compact('reply', 'course') )->render();
                    return json_encode($response);
                }
		return Redirect::back();
            }
            else{
                return Redirect::back()->withErrors( format_errors( $reply->errors()->all() ) );
            }
	}
        
        public function vote($id, $vote){
            $reply = LessonDiscussionReply::find($id);
            
            $student = Student::find( Auth::user()->id );
            $lesson = Lesson::find( $reply->discussion->lesson_id );
            
            
            
            $votes = $reply->vote( Auth::user()->id, $vote );
            
            if( Request::ajax() ){
                return json_encode( ['status' => 'success', 'votes' => $votes] );
            }
            else{
                return Redirect::back();
            }
        }

}