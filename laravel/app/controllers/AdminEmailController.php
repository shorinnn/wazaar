<?php

class AdminEmailController extends \BaseController {
    
	public function publishers()
	{
		return View::make('administration.emails.publishers');
	}
        
	public function sendPublishers()
	{
            $content = trim(strip_tags(Input::get('content'))); 
            if( $content!='' ){
                $date = date('Y-m-d', strtotime( Input::get('date') ) );
                $recipients = User::whereHas(
                        'roles', function($q){
                        $q->where('name', 'Instructor');
                    })->where('is_second_tier_instructor','no')->where('created_at','<=', $date)->get();
                    
                $subject = Input::get('subject');
                $sent = '';
                $mailsSent = 0;
                foreach($recipients as $recipient){
                    $sent .= $recipient->email('Instructor').$recipient->created_at.', ';
                    Mail::send('emails.to-publishers', array('content' => $content), function($message) use ($recipient, $subject)  {
                        $message->to( $recipient->email('Instructor') , $recipient->fullName() )->subject( $subject );
                    });
                    ++$mailsSent;
                }
                
                
                if( Request::ajax() ){
                    return json_encode( ['status' => 'success', 'message' => 'sent', 'date'=>$date, 'sent' => $sent, 'mails_sent' => $mailsSent ] );
                }
                else{
                    Session::flash('success', trans('conversations/general.sent' ));
                    return Redirect::back();
                }
            }
            else{
               if( Request::ajax() ){
                    return json_encode( ['status' => 'error', 'errors' => trans('crud/errors.error_occurred' ) ] );
                }
                else{
                    Session::flash('error', trans('crud/errors.error_occurred' ));
                    return Redirect::back();
                } 
            }
	}


}