<?php

class EmailsController extends \BaseController {
        public function __construct(){
            $this->beforeFilter('admin');
        }
        
	public function index()
	{
            // lil dev change
            $instructorSaleEmail = Setting::firstOrCreate( [ 'name' => 'instructor-email-sale-content' ] );
            $instructorSaleEmailSubject = Setting::firstOrCreate( [ 'name' => 'instructor-email-sale-subject' ] );
            
            $studentSaleEmail = Setting::firstOrCreate( [ 'name' => 'student-email-sale-content' ] );
            $studentSaleEmailSubject = Setting::firstOrCreate( [ 'name' => 'student-email-sale-subject' ] );
            
            $instructorNewDiscussionsUpdateEmail = Setting::firstOrCreate( [ 'name' => 'instructor-new-discussions-update-content' ] );
            $instructorNewDiscussionsUpdateEmailSubject = Setting::firstOrCreate( [ 'name' => 'instructor-new-discussions-update-subject' ] );
            
            $contactFormSubmittedWazaar = Setting::firstOrCreate( [ 'name' => 'contact-form-submitted-wazaar-content' ] );
            $contactFormSubmittedWazaarSub = Setting::firstOrCreate( [ 'name' => 'contact-form-submitted-wazaar-subject' ] );
            $contactFormSubmittedUser = Setting::firstOrCreate( [ 'name' => 'contact-form-submitted-user-content' ] );
            $contactFormSubmittedUserSub = Setting::firstOrCreate( [ 'name' => 'contact-form-submitted-user-subject' ] );
            return View::make('administration.emails.index')->with( compact('instructorSaleEmail', 'studentSaleEmail', 
                    'instructorNewDiscussionsUpdateEmail', 'contactFormSubmittedWazaar', 'contactFormSubmittedUser', 'contactFormSubmittedUserSub',
                    'contactFormSubmittedWazaarSub', 'instructorSaleEmailSubject', 'studentSaleEmailSubject', 'instructorNewDiscussionsUpdateEmailSubject'
                    ) );
	}
        
        public function update(){
            foreach( Input::get('fields') as $name=>$val ){
                $set = Setting::where('name', $val)->first();
                $set->value = Input::get( $val );
                $set->updateUniques();
            }
            
            if(Request::ajax()) return json_encode (['status'=>'success']);
            return Redirect::back()->withSuccess('Email Updated');
        }

	

}