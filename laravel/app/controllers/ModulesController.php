<?php

class ModulesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor' );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy']]);
        }
        
        public function store($course){
            $module = new Module();
            $course = Course::find($course);
            if($course->instructor->id != Auth::user()->id){
                $response = ['status' => 'error', 'errors' => trans('crud/errors.error_occurred') ];
                return json_encode($response);
            }
            
            $module->course_id = $course->id;
            $module->name = 'New Module';
            $module->order = $course->modules->count() + 1;
            if($module->save()){
                if(Request::ajax()){
                    $response = ['status' => 'success', 
                                 'id' => $module->id, 
                                 'html' => View::make('courses.modules.module')->with(compact('module'))->render() ];
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
            if($module!=null && $module->course->instructor->id == Auth::user()->id){
                $module->delete();
                $response = ['status' => 'success'];
                return json_encode($response);
            }
            $response = ['status' => 'error', 'errors' => trans('crud/errors.cannot_delete_object', 'Module') ];
            return json_encode($response);
        }
        
        public function update($course, $id){
            $module = Module::find($id);
            if($module!=null && $module->course->instructor->id == Auth::user()->id){
                $name = Input::get('name');
                $module->$name = Input::get('value');
                $module->save();
                $response = ['status' => 'success'];
                return json_encode($response);
            }
            $response = ['status' => 'error', 'errors' => trans('crud/errors.cannot_save_object', 'Module') ];
            return json_encode($response);
        }
        
}
