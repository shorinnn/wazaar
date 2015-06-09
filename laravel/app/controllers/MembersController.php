<?php

class MembersController extends \BaseController {
    
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
            
            $url_filters = [];
            $params = array_merge( $_GET, array("type" => "student", 'page' => 1));
            $url_filters['student'] = http_build_query($params);
            $params = array_merge( $_GET, array("type" => "instructor", 'page' => 1));
            $url_filters['instructor'] = http_build_query($params);
            $params = array_merge( $_GET, array("type" => "affiliate", 'page' => 1));
            $url_filters['affiliate'] = http_build_query($params);
            
//            if( !Input::get('type') ) $members = User::with('profiles')->paginate( $pagination );
//            else $members = Role::where('name', Input::get('type'))->first()->users()->with('profiles')->paginate( $pagination );
            if( !Input::get('type') ) $members = User::with('profiles');
            else $members = Role::where('name', Input::get('type'))->first()->users()->with('profiles');
            
            if( Input::get('search') )$members = $members->where('email', 'like', '%'.Input::get('search').'%' );
            
            $members = $members->paginate( $pagination );
            
            if( Request::ajax() ){
                return View::make('administration.members.partials.table')->with( compact('members') )->with( compact('url_filters') )->render();
            }
            Return View::make('administration.members.index')->with(compact('members'))->with( compact('url_filters') );
	}
        
     

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            $user = User::find($id);
            $student = Student::find($id);
            $adminHelper = new AdminHelper();
            
            if($student==null){
                return Redirect::action('MembersController@index')->withError( trans('crud/errors.object_doesnt_exist', ['object' => 'User' ]) );
            }
            return View::make('administration.members.show')->with(compact('student', 'adminHelper'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            $user = User::find($id);
            $instructor_agencies = InstructorAgency::all()->lists('username', 'id');
            $instructor_agencies = ['NULL' => ''] + $instructor_agencies;
            if($user==null){
                return Redirect::action('MembersController@index')->withError( trans('crud/errors.object_doesnt_exist', ['object' => 'User' ]) );
            }
            return View::make('administration.members.edit')->with( compact('user') )->with( compact('instructor_agencies') );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $user = User::find($id);
            if($user==null){
                return Redirect::action('MembersController@index')->withError( trans('crud/errors.object_doesnt_exist', ['object' => 'User' ]) );
            }
            $user->status = Input::get('status');
            $user->instructor_agency_id = Input::get('instructor_agency_id') == 0 ? null : Input::get('instructor_agency_id');
           if( $user->update( input_except(['_method', '_token'] ) ) ){
                if(Request::ajax()) return json_encode( ['status'=>'success'] );
                return Redirect::back()->withSuccess( trans('crud/errors.object_updated', ['object'=>'User'] ));
            }
            else{
                if(Request::ajax()) return json_encode( ['status'=>'error', 'errors' => format_errors($user->errors()->all()) ] );
                return Redirect::back()->withError( trans('crud/errors.cannot_update_object',['object'=>'User']).': '.format_errors($user->errors()->all()));
            }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            $user = User::find($id);
            if($user==null){
                return Redirect::action('MembersController@index')->withError( trans('crud/errors.object_doesnt_exist', ['object' => 'User' ]) );
            }
            if($user->delete($id)){
                return Redirect::back()->withSuccess( trans('crud/errors.object_deleted',['object'=>'User']));
            }
            else{
                return Redirect::back()->withError( trans('crud/errors.cannot_delete_object',['object'=>'User']).': '.format_errors($user->errors()->all()));
            }
	}
        
        public function refund(){
            $purchase = Purchase::find( Input::get('purchase') );
            $refund = $purchase->refund();
            if(!$refund){
                if( !Request::ajax() ){
                    return Redirect::back();
                }
                else{
                    return json_encode( [ 'status' => 'error', 'errors' => trans('administration.not-refundable') ] );
                }
            }
            if( !Request::ajax() ){
                return Redirect::back();
            }
            else {
                $i = $refund->student->refunds()->count();
                $html = View::make('administration.members.partials.refund')->with( compact('refund', 'i') )->render();
                return json_encode( [ 'status' => 'success', 'html' => $html ] );
            }
        }


}
