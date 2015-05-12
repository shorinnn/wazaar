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
        
        public function bankFile($time=''){
            
            if($time=='') $time = date('Y-m-01');
            return View::make('administration.withdrawals.bank_file')->withTime( $time );
        }
        
        public function downloadBankFile(){
            $content = WithdrawalsHelper::generateFile( Input::get('time') );
            $title = date('m-Y', strtotime( Input::get('time') ) );
            header("Content-Disposition: attachment; filename=\"" . $title. ".txt\"");
            header("Content-Type: application/force-download");
            header("Content-Length: " . strlen($content));
            header("Connection: close");
            exit($content);
        }

}