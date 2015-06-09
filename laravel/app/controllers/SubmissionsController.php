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
          
           
            $submissions = Course::with('instructor')->where('publish_status','pending')->paginate( $pagination );
            
            if( Request::ajax() ){
                return View::make('administration.submissions.partials.table')->with( compact('members') );
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
           if( $course->updateUniques () ){
                if(Request::ajax()) return json_encode( ['status'=>'success'] );
                return Redirect::back()->withSuccess( trans('crud/errors.object_updated', ['object'=>'Course'] ));
            }
            else{
                if(Request::ajax()) return json_encode( ['status'=>'error', 'errors' => format_errors($course->errors()->all()) ] );
                return Redirect::back()->withError( trans('crud/errors.cannot_update_object',['object'=>'Course']).': '.format_errors($course->errors()->all()));
            }
	}

}
