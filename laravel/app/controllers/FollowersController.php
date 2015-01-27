<?php

class FollowersController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'auth' );
            $this->beforeFilter( 'csrf', [ 'only' => ['store','destroy'] ] );
        }
        
       public function store(){
            FollowRelationship::create( ['student_id' => Auth::user()->id, 'instructor_id' => Input::get('instructor')] );
            if( Request::ajax() ){
                $instructor = Instructor::find( Input::get('instructor') );
                $response = ['status' => 'success', 'html' => View::make('courses.followed_form')->withInstructor($instructor)->render() ];
                return json_encode($response);
            }
            return Redirect::back();
       }
       
        function destroy(){
            FollowRelationship::where('student_id', Auth::user()->id)->where('instructor_id', Input::get('instructor'))->delete();
            if( Request::ajax() ){
                $instructor = Instructor::find( Input::get('instructor') );
                $response = ['status' => 'success', 'html' => View::make('courses.followed_form')->withInstructor($instructor)->render() ];
                return json_encode($response);
            }
            return Redirect::back();
        }
}
