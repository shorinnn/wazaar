<?php

class CoursesSubcategoriesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin', ['except' => 'subcategories']);
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update','destroy' ]]);
        }
        
        public function store(){
            $subcategory = new CourseSubcategory;
            $subcategory->course_category_id = Input::get('category_id');
            $subcategory->name = Input::get('name');
            if(Request::ajax()){
                if( $subcategory->save() ) {
                    return json_encode ( [ 'status'=>'success', 
                                           'html' => View::make('administration.course_categories.subcategory')->with(compact('subcategory'))->render() ] );
                }
                else return json_encode( [ 'status'=>'error', 'errors' => format_errors($subcategory->errors()->all()) ] );
            }
            else{
                if( $subcategory->save() ) return Redirect::back();
                else return Redirect::back()->withErrors( format_errors( $subcategory->errors()->all() ) );
            }
        }
        
        public function update($id){
            $subcategory = CourseSubcategory::find($id);
            $name = Input::get('name');
            $subcategory->$name = Input::get('value');
            $subcategory->save();
            $response = ['status' => 'success'];
            if(Request::ajax()) return json_encode($response);
            else return Redirect::back();
        }

        public function destroy($id){
            $subcategory = CourseSubcategory::find($id);
            $subcategory->delete();
            $response = ['status' => 'success'];
            if(Request::ajax())            return json_encode($response);
            else return Redirect::back();
        }
        
}
