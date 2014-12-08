<?php

class MembersController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin');
        }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $members = User::paginate(2);
            Return View::make('administration.members.index')->with(compact('members'));
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
            return View::make('administration.members.show')->with(compact('user'));
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
            return View::make('administration.members.edit')->with(compact('user'));
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
            if($user->update( input_except(['_method', '_token'] ))){
                return Redirect::back()->withSuccess( trans('crud/errors.object_updated', ['object'=>'User'] ));
            }
            else{
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
            if($user->delete($id)){
                return Redirect::back()->withSuccess( trans('crud/errors.object_deleted',['object'=>'User']));
            }
            else{
                return Redirect::back()->withError( trans('crud/errors.cannot_delete_object',['object'=>'User']).': '.format_errors($user->errors()->all()));
            }
	}


}
