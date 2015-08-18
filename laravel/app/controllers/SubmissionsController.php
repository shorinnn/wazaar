<?php

class SubmissionsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin');
            $this->beforeFilter('csrf', ['only' => [ 'update','destroy' ]]);
        }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $pagination = Input::get('view') > 0 ? Input::get('view') :  2;
//            $page = Input::get('page');
           
            $submissions = Course::with('instructor')->where('publish_status','pending')->paginate( $pagination );
            
            if( Request::ajax() ){
                return View::make('administration.submissions.partials.table')->with( compact('submissions') );
            }
            Return View::make('administration.submissions.index')->with( compact('submissions') );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $course = Course::find($id);
            if($course==null){
                return Redirect::action('SubmissionsController@index')->withError( trans('crud/errors.object_doesnt_exist', ['object' => 'Course' ]) );
            }
            $course->publish_status = Input::get('value');
            $course->reject_reason = Input::get('reject_reason');    
            if(Input::get('value')=='approved'){
               $course->pre_submit_data = json_encode($course);
               $course->reject_reason = '';    
            }
            if( $course->updateUniques () ){
                $user = $course->instructor;
                if(Input::get('value')=='approved'){
                    $subject = 'Course Approved';
                    $content = EmailTemplate::where('tag','course-approved')->first()->content;
                }
                else{
                    $subject = 'Course Rejected';
                    $content = EmailTemplate::where('tag','course-rejected')->first()->content;
                }
                
                $content = str_replace('@NAME@', $user->commentName("Instructor"), $content);
                $content = str_replace('@COURSENAME@', $course->name, $content);
                $content = str_replace('@LINK@', action('CoursesController@show', $course->slug), $content);
                $content = str_replace('@REASONS@', $course->reject_reason, $content);
                Mail::send(
                        'emails.simple',
                        compact( 'content' ),
                        function ($message) use ($user, $subject) {
                            $message->getHeaders()->addTextHeader('X-MC-Important', 'True');
                            $message
                                ->to($user->email, $user->email)
                                ->subject( $subject );
                        }
                    );
                    
                if(Request::ajax()) return json_encode( ['status'=>'success'] );
                return Redirect::back()->withSuccess( trans('crud/errors.object_updated', ['object'=>'Course'] ));
            }
            else{
                if(Request::ajax()) return json_encode( ['status'=>'error', 'errors' => format_errors($course->errors()->all()) ] );
                return Redirect::back()->withError( trans('crud/errors.cannot_update_object',['object'=>'Course']).': '.format_errors($course->errors()->all()));
            }
	}
        
        public function allCourses(){
            $pagination = Input::get('view') > 0 ? Input::get('view') :  2;
            
            $submissions = Course::orderBy('id','desc')->paginate( $pagination );
            
            if( Request::ajax() ){
                return View::make('administration.submissions.all.partials.table')->with( compact('submissions') );
            }
            Return View::make('administration.submissions.all.index')->with( compact('submissions') );
        }

}
