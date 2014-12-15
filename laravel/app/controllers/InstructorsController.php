<?php

class InstructorsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'nonInstructor', ['only' => 'become'] );
            $this->beforeFilter( 'instructor', [ 'except' => ['start', 'become', 'doBecome'] ] );
        }

	public function index()
	{
            Return View::make('instructors/index');
	}
        
        public function start($user){
            Session::set( 'url.intended', action('InstructorsController@become') );
            if($user=='new-user'){
                return Redirect::to('register/1');
            }
            else{
                return Redirect::action('UsersController@login');
            }
        }
        
        public function become()
	{
            Return View::make('instructors/become');
	}
        
        public function doBecome(){
            $users = new UserRepository();
            if($users->become( 'Instructor', Auth::user()) ){
                return Redirect::action('InstructorsController@index')->withSuccess( trans('instructors/general.congratulations_become_instructor') );
            }
            else{
                return Redirect::action('InstructorsController@index')->withError( trans('instructors/general.already_instructor') );
            }
        }
}
