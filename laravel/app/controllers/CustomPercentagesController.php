<?php

class CustomPercentagesController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter( 'instructor' );
        }

	public function store()
	{
                $affiliates = [0 => 'Select...'] + ProductAffiliate::arrayWithProfile();
                $customPercentage = new CourseAffiliateCustomPercentage();
                $customPercentage->percentage = 0;
                $customPercentage->course_id = Input::get('course_id');
                $customPercentage->affiliate_id = 0;
                if( $customPercentage->updateUniques() ){
                    return json_encode( ['status'=>'success', 
                        'html' => View::make('courses.custom_percentage')->with(compact('customPercentage', 'affiliates'))->render() ] );
                }
                else{
                    $response = ['status' => 'error', 'errors' => trans('crud/errors.cannot_update_object', ['object' => '' ]) ];
                    return json_encode($response);
                }
	}

	
	public function update($id)
	{
            $custom = CourseAffiliateCustomPercentage::find($id);
            if($custom!=null &&  $custom->course->instructor->id == Auth::user()->id  ){
                $name = Input::get('name');
                $custom->$name = Input::get('value');
                if( $custom->updateUniques() ){
                    $response = ['status' => 'success'];
                    return json_encode($response);
                }
            }
            
            $response = ['status' => 'error', 'errors' => trans('crud/errors.cannot_update_object', ['object' => '']) ];
//            $response = ['status' => 'error', 'errors' => trans('crud/errors.cannot_update_object', ['object' => format_errors( $custom->errors()->all()) ]) ];
            return json_encode($response);
	}

	public function destroy($id)
	{
            $custom = CourseAffiliateCustomPercentage::find($id);
            if($custom!=null &&  $custom->course->instructor->id == Auth::user()->id  ){
                $custom->delete();
                $response = ['status' => 'success'];
                return json_encode($response);
            }
            
            $response = ['status' => 'error', 'errors' => trans('crud/errors.cannot_delete_object', ['object' => '']) ];
            return json_encode($response);
	}

}