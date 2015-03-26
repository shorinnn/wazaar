<?php

class WithdrawalsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin');
            $this->beforeFilter('csrf', ['only' => [ 'update','destroy' ]]);
        }


	public function index()
	{
                $types = [ 'instructor_agency_debit', 'instructor_debit', 'affiliate_debit' ];
		$requests = Transaction::whereIn('transaction_type',$types)->where('status','pending')->paginate( 2 );
                if( Request::ajax() ){
                    return View::make('administration.withdrawals.partials.table')->with( compact('requests') );
                }
                return View::make('administration.withdrawals.index')->with( compact('requests') );
	}
        
        public function update(){
            if( Input::get('action')=='complete'){
                WithdrawalsHelper::complete( Input::get('request'), Input::get('reference') );
            }
            if( Input::get('action')=='reject'){
                WithdrawalsHelper::reject( Input::get('request') );
            }
            return Redirect::back();
        }


}