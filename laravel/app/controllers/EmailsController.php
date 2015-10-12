<?php

class EmailsController extends \BaseController {
        public function __construct(){
            $this->beforeFilter('admin');
        }
        
	public function index()
	{
            // lil dev change
            $instructorSaleEmail = Setting::firstOrCreate( [ 'name' => 'instructor-email-sale-content' ] );
            $studentSaleEmail = Setting::firstOrCreate( [ 'name' => 'student-email-sale-content' ] );
            $instructorNewDiscussionsUpdateEmail = Setting::firstOrCreate( [ 'name' => 'instructor-new-discussions-update-content' ] );
            $contactFormSubmittedWazaar = Setting::firstOrCreate( [ 'name' => 'contact-form-submitted-wazaar-content' ] );
            $contactFormSubmittedUser = Setting::firstOrCreate( [ 'name' => 'contact-form-submitted-user-content' ] );
            return View::make('administration.emails.index')->with( compact('instructorSaleEmail', 'studentSaleEmail', 
                    'instructorNewDiscussionsUpdateEmail', 'contactFormSubmittedWazaar', 'contactFormSubmittedUser' ) );
	}
        
        public function update(){
            $email = Setting::where('name', Input::get('name'))->first();
            $email->value = Input::get('content');
            $email->updateUniques();
            if(Request::ajax()) return json_encode (['status'=>'success']);
            return Redirect::back()->withSuccess('Email Updated');
        }

	

}