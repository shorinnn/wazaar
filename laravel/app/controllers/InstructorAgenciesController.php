<?php

class InstructorAgenciesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin', ['except' => 'subcategories']);
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update','destroy' ]]);
        }

	public function index()
	{
		Return View::make('administration.instructor_agencies.index');
	}

	public function store()
	{
            $agency = new InstructorAgency;
            $agency->username = 'ag-'.time();
            $agency->email = Input::get('email');
            $agency->password = Input::get('password');
            $agency->password_confirmation = Input::get('password_confirmation');
            $agencyRole = Role::where('name','=','InstructorAgency')->first();
            if(Request::ajax()){
                if( $agency->save() ) {
                    $agency->attachRole( $agencyRole );
                    return json_encode ( [ 'status'=>'success', 
                                           'html' => View::make('administration.instructor_agencies.agency')->with(compact('agency'))->render() ] );
                }
                else return json_encode( [ 'status'=>'error', 'errors' => format_errors($agency->errors()->all()) ] );
            }
            else{
                if( $agency->save() ){
                    $agency->attachRole( $agencyRole );
                    return Redirect::back();
                }
                else return Redirect::back()->withErrors( format_errors( $agency->errors()->all() ) );
            }
	}
        
	
	public function update($id)
	{
            $agency = InstructorAgency::find($id);
            $name = Input::get('name');
            $agency->$name = Input::get('value');
            $agency->save();
            $response = ['status' => 'success'];
            if(Request::ajax()) return json_encode($response);
            else return Redirect::back();
	}

	public function destroy($id)
	{
            $agency = InstructorAgency::find($id);
            if( $agency->delete() ) $response = ['status' => 'success'];
            else $response = ['status' => 'error', 'errors' => format_errors( $agency->errors()->all() ) ];
            
            if(Request::ajax()) return json_encode($response);
            else return Redirect::back();
	}
        
        public function instructors($id){
            $instructors = InstructorAgency::find($id)->instructors;
            return View::make('administration.instructor_agencies.instructor')->with( compact('instructors') )->render();
        }

}