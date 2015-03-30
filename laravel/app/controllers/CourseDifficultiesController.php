<?php

class CourseDifficultiesController extends \BaseController {

        public function __construct(){
            $this->beforeFilter('admin' );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update','destroy' ]]);
        }
        
        public function index(){
            Return View::make('administration.course_difficulties.index');
        }
        
        public function store(){
            $difficulty = new CourseDifficulty;
            $difficulty->name = Input::get('name');
            if(Request::ajax()){
                if( $difficulty->save() ) {
                    return json_encode ( [ 'status'=>'success', 
                                           'html' => View::make('administration.course_difficulties.difficulty')->with(compact('difficulty'))->render() ] );
                }
                else return json_encode( [ 'status'=>'error', 'errors' => format_errors($difficulty->errors()->all()) ] );
            }
            else{
                if( $difficulty->save() ) return Redirect::back();
                else return Redirect::back()->withErrors( format_errors( $difficulty->errors()->all() ) );
            }
        }
        
        public function update($id){
            $difficulty = CourseDifficulty::find($id);
            $name = Input::get('name');
            $difficulty->$name = Input::get('value');
            $difficulty->save();
            $response = ['status' => 'success'];
            if(Request::ajax()) return json_encode($response);
            else return Redirect::back();
        }

        public function destroy($id){
            $difficulty = CourseDifficulty::find($id);
            if( $difficulty->delete() ) $response = ['status' => 'success'];
            else $response = ['status' => 'error', 'errors' => format_errors( $difficulty->errors()->all() ) ];
            
            if(Request::ajax()) return json_encode($response);
            else return Redirect::back();
        }

}