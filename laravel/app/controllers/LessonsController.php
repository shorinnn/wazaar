<?php

class LessonsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor' );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy']]);
        }

	public function store(){
            $lesson = new Lesson();
            $module = Module::find(Input::get('module_id'));
            if($module->course->instructor->id != Auth::user()->id){
                $response = ['status' => 'error', 'errors' => trans('crud/errors.error_occurred') ];
                return json_encode($response);
            }
            
            $lesson->module_id = $module->id;
            $lesson->name = 'New Lesson';
            $lesson->order = $module->lessons->count() + 1;
            if($lesson->save()){
                $response = ['status' => 'success', 
                             'module' => $lesson->module_id, 
                             'html' => View::make('courses.lessons.lesson')->with(compact('lesson'))->render() ];
                return json_encode($response);
            }
            else{
                $response = ['status' => 'error', 'errors' => format_errors($lesson->errors()->all())];
                return json_encode($response);
            }
        }
        
        public function destroy($id){
            $lesson = Lesson::find($id);
            if($lesson!=null && $lesson->module->course->instructor->id == Auth::user()->id){
                $lesson->delete();
                $response = ['status' => 'success'];
                return json_encode($response);
            }
            $response = ['status' => 'error', 'errors' =>  trans('crud/errors.cannot_delete_object', 'Lesson')  ];
            return json_encode($response);
        }
        
        public function update($id){
            $lesson = Lesson::find($id);
            if($lesson!=null && $lesson->module->course->instructor->id == Auth::user()->id){
                $name = Input::get('name');
                $lesson->$name = Input::get('value');
                $lesson->save();
                $response = ['status' => 'success'];
                return json_encode($response);
            }
            $response = ['status' => 'error', 'errors' =>  trans('crud/errors.cannot_save_object', 'Lesson') ];
            return json_encode($response);
        }
        
        



}
