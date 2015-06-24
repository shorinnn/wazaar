<?php

class LessonsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor' );
            $this->beforeFilter('csrf', ['only' => [ 'store', 'update', 'destroy']]);
        }

	public function store($module){
            $lesson = new Lesson();
            $module = Module::find($module);
            if($module->course->instructor->id != Auth::user()->id && $module->course->assigned_instructor_id != Auth::user()->id){
                $response = ['status' => 'error', 'errors' => trans('crud/errors.error_occurred') ];
                return json_encode($response);
            }
            
            $lesson->module_id = $module->id;
//            $lesson->name = 'New Lesson';
            $lesson->order = $module->lessons->count() + 1;
            if($lesson->save()){
                if(Request::ajax()){
                    $response = ['status' => 'success', 
                                 'module' => $lesson->module_id, 
                                 'html' => View::make('courses.lessons.lesson')->with(compact('lesson'))->render() ];
                    return json_encode($response);
                }
                else{
                    return Redirect::back();
                }
            }
            else{
                if(Request::ajax()){
                    $response = ['status' => 'error', 'errors' => format_errors($lesson->errors()->all())];
                    return json_encode($response);
                }
                else{
                    return Redirect::back()->withError( format_errors( $lesson->errors()->all() ) );
                }
            }
        }
        
        public function destroy($module, $id){
            $lesson = Lesson::find($id);
            if($lesson!=null && ( $lesson->module->course->instructor->id == Auth::user()->id 
                    || $lesson->module->course->assigned_instructor_id == Auth::user()->id ) ){
                $lesson->delete();
                $response = ['status' => 'success'];
                if(!Request::ajax()) return Redirect::back();
                return json_encode($response);
            }
            if(!Request::ajax()) return Redirect::back();
            $response = ['status' => 'error', 'errors' =>  trans('crud/errors.cannot_delete_object', ['object' => 'Lesson'])  ];
            return json_encode($response);
        }
        
        public function update($module, $id){
            $lesson = Lesson::find($id);
            
            // validate Youtube/Vimeo Link if field is external_video_url
            if(Input::get('name')=='external_video_url'){
                if( !validateExternalVideo(Input::get('value')) ){
                    $response = ['status' => 'error', 'errors' =>  trans('crud/errors.invalid_video_url') ];
                    return json_encode($response);
                }
                    
            }
            if($lesson!=null && ( $lesson->module->course->instructor->id == Auth::user()->id 
                    || $lesson->module->course->assigned_instructor_id == Auth::user()->id ) ){
                $name = Input::get('name');
                $lesson->$name = Input::get('value');
                if( $lesson->save() ){
                    $response = ['status' => 'success'];
                    return json_encode($response);
                }
                else{
                    $response = ['status' => 'error', 'errors' => format_errors( $lesson->errors()->all() ) ];
                    return json_encode($response);
                }
            }
            $response = ['status' => 'error', 'errors' =>  trans('crud/errors.cannot_save_object', 'Lesson') ];
            return json_encode($response);
        }
        
        public function details($module, $id){
            $lesson = Lesson::find($id);
            if( $lesson!=null && ( $lesson->module->course->instructor->id == Auth::user()->id 
                    || $lesson->module->course->assigned_instructor_id == Auth::user()->id )  ){
                return View::make('courses.lessons.details')->with(compact('lesson'));
            }
        }

}
