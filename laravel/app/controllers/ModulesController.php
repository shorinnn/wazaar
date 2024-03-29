<?php

class ModulesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor' );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update' ]]);
        }
        
        public function store($course){
            $module = new Module();
            $course = Course::find($course);
            if( !admin() && $course->instructor->id != Auth::user()->id && $course->assigned_instructor_id != Auth::user()->id ){
                $response = ['status' => 'error', 'errors' => trans('crud/errors.error_occurred') ];
                return json_encode($response);
            }
            $module->course_id = $course->id;
            $module->name = '';
            $module->order = $course->modules->count() + 1;
            if($module->save()){
                if(Request::ajax()){
                    $response = ['status' => 'success', 
                                 'id' => $module->id, 
                                 'li' => View::make('courses.editor.v2.module_li')->with(compact('module'))->render(),
                                 'html' => View::make('courses.editor.v2.module')->with(compact('module'))->render() ];
                    //'html' => View::make('courses.modules.module')->with(compact('module'))->render()
                    return json_encode($response);
                }
                else{
                    return Redirect::back();
                }
            }
            else{
                if(Request::ajax()){
                    $response = ['status' => 'error', 'errors' => format_errors($module->errors()->all())];
                    return json_encode($response);
                }
                else{
                    return Redirect::back()->withError( format_errors( $module->errors()->all() ) );
                }
            }
        }
        
        public function destroy($course, $id){
            $module = Module::find($id);
            if($module!=null && ( $module->course->instructor->id == Auth::user()->id 
                    || $module->course->assigned_instructor_id == Auth::user()->id || admin() ) ){
                $module->delete();
                $response = ['status' => 'success'];
                if(!Request::ajax()) return Redirect::back();
                return json_encode($response);
            }
            $response = ['status' => 'error', 'errors' => trans('crud/errors.cannot_delete_object',['object' => 'Module']) ];
            if(!Request::ajax()) return Redirect::back();
            return json_encode($response);
        }
        
        public function update($course, $id){
            $module = Module::find($id);
            if($module!=null && ( $module->course->instructor->id == Auth::user()->id 
                    || $module->course->assigned_instructor_id == Auth::user()->id || admin() ) ){
                $name = Input::get('name');
                $module->fill( Input::all() );
                
                if($module->save()){
                    $response = ['status' => 'success'];
                    return json_encode($response);
                }
                else{
                    $response = ['status' => 'error', 'errors' => format_errors( $module->errors()->all() ) ];
                    return json_encode($response);
                }
            }
            $response = ['status' => 'error', 'errors' => trans('crud/errors.cannot_save_object', ['object' => 'Module']) ];
            return json_encode($response);
        }
        
}
