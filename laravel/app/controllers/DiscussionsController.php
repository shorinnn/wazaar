<?php

class DiscussionsController extends \BaseController {
    
        public function show($id){
            $discussion = LessonDiscussion::find($id);
            $course = $discussion->lesson->module->course;
            if(Request::ajax()){
                $response['status'] = 'success';
                $response['html'] = View::make('courses.classroom.discussions.replies')->with( compact('discussion', 'course') )->render();
                $response['title'] = $discussion->title;
                return json_encode($response);
            }
            return View::make('courses.classroom.discussions.replies')->with( compact('discussion', 'course') );
        }

	/**
	 * Store a newly created resource in storage.
	 * POST /discussions
	 *
	 * @return Response
	 */
	public function store()
	{
            $discussion = new LessonDiscussion(Input::all());
            $discussion->student_id = Auth::user()->id;
            if( $discussion->save() ){
                if( Request::ajax() ){
                    $response['status'] = 'success';
                    $response['html'] = View::make('courses.classroom.discussions.question')->with( compact('discussion') )->render();
                    return json_encode($response);
                }
		return Redirect::back();
            }
            else{
                if( Request::ajax() ){
                    $response['status'] = 'error';
                    $response['errors'] = format_errors( $discussion->errors()->all() );
                    return json_encode($response);
                }
                return Redirect::back()->withErrors( format_errors( $discussion->errors()->all() ) );
            }
	}

        public function vote($id, $vote){
            $discussion = LessonDiscussion::find($id);
            
            $student = Student::find( Auth::user()->id );
            $lesson = Lesson::find( $discussion->lesson_id );
            if( !$student->purchased($lesson->module->course) && !$student->purchased( $lesson ) ){
                if( Request::ajax() ){
                    $response['status'] = 'error';
                    $response['errors'] = '';
                    return json_encode($response);
                }
                return Redirect::back()->withErrors( '' );
            }
            
            if( !$student->purchased($lesson->module->course) && !$student->purchased( $lesson ) ){
                if( Request::ajax() ){
                    $response['status'] = 'error';
                    $response['errors'] = '';
                    return json_encode($response);
                }
                return Redirect::back()->withErrors( '' );
            }
            
            
            $votes = $discussion->vote( Auth::user()->id, $vote );
            
            if( Request::ajax() ){
                return json_encode( ['status' => 'success', 'votes' => $votes] );
            }
            else{
                return Redirect::back();
            }
        }

}