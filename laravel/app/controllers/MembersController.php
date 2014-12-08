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
            // try new deploy script
            $user = User::find($id);
		return "showing $id";
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
                return Redirect::back()->withSuccess('User deleted');
            }
            else{
                return Redirect::back()->withError('Cannot delete user');
            }
	}


}
