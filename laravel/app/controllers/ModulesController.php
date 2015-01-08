<?php

class ModulesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor' );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy']]);
        }
        
        public function store(){
            $module = new Module();
            $course = Course::find(Input::get('course_id'));
            $module->course_id = $course->id;
            $module->name = 'New Module';
            $module->order = $course->modules->count() + 1;
            if($module->save()){
                $response = ['status' => 'success', 
                             'module' => $module, 
                             'html' => View::make('courses.modules.module')->with(compact('module'))->render() ];
                return json_encode($response);
            }
            else{
                $response = ['status' => 'error', 'errors' => format_errors($module->errors()->all())];
                return json_encode($response);
            }
        }
        
        public function destroy($id){
            $module = Module::find($id);
            if($module!=null && $module->course->instructor->id == Auth::user()->id){
                $module->delete();
                $response = ['status' => 'success'];
                return json_encode($response);
            }
            $response = ['status' => 'error', 'errors' => 'Cannot delete this module'];
            return json_encode($response);
        }
        
}
