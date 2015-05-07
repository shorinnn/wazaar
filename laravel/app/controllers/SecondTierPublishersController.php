<?php

class SecondTierPublishersController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin');
            $this->beforeFilter('csrf', ['only' => [ 'update' ]]);
        }

	/**
	 * Display a listing of the resource.
	 * GET /secondtierpublishers
	 *
	 * @return Response
	 */
	public function index()
	{
            $members = User::where('is_second_tier_instructor','yes')->paginate(20);
            
            if( Request::ajax() ){
                return View::make('administration.second_tier_pub.partials.table')->with( compact('members') )->render();
            }
            Return View::make('administration.second_tier_pub.index')->with(compact('members'));
	}

	public function update($id)
	{
            $user = User::find($id);
            $user->sti_approved = trim( strtolower( Input::get('value') ) );
           if( $user->updateUniques() ){
                if(Request::ajax()) return json_encode( ['status'=>'success','eh' => Input::get('value') ] );
                return Redirect::back()->withSuccess( trans('crud/errors.object_updated', ['object'=>'User'] ));
            }
            else{
                if(Request::ajax()) return json_encode( ['status'=>'error', 'errors' => format_errors($user->errors()->all()) ] );
                return Redirect::back()->withError( trans('crud/errors.cannot_update_object',['object'=>'User']).': '.format_errors($user->errors()->all()));
            }
	}

}