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
        
        public function processDate(){
            $hour = Setting::firstOrCreate( [ 'name' => 'cashout-cron-hour' ] );
            $setting = Setting::firstOrCreate( [ 'name' => 'cashout-cron-date' ] );
            $options = [];
            for($i=1; $i<29;++$i){
                $j = ($i>9) ? $i : "0$i";
                $time = strtotime("2015-01-$j");
                $options[$j] = $i.date('S', $time);
            }
            $options['MONDAY'] = 'EVERY MONDAY';
            $options['TUESDAY'] = 'EVERY TUESDAY';
            $options['WEDNESDAY'] = 'EVERY WEDNESDAY';
            $options['THURSDAY'] = 'EVERY THURSDAY';
            $options['FRIDAY'] = 'EVERY FRIDAY';
            $options['SATURDAY'] = 'EVERY SATURDAY';
            $options['SUNDAY'] = 'EVERY SUNDAY';
           
            $hourOptions=[];
            for($i=0; $i<24;++$i){
                $j = ($i>9) ? $i : "0$i";
                $time = strtotime("2015-01-01 $j:00:00");
                $hourOptions[$i] = date('ga', $time);
            }
            
            return View::make('administration.withdrawals.settings')->with( compact('setting', 'options','hourOptions', 'hour') );
        }
        
        public function doProcessDate(){
            $hour = Setting::firstOrCreate( [ 'name' => 'cashout-cron-hour' ] );
            $setting = Setting::firstOrCreate( [ 'name' => 'cashout-cron-date' ] );
            $hour->value = Input::get('hour');
            $hour->updateUniques();
            
            $setting->value = Input::get('date');
            $setting->updateUniques();
            
            $options = [];
            for($i=1; $i<29;++$i){
                $j = ($i>9) ? $i : "0$i";
                $time = strtotime("2015-01-$j");
                $options[$j] = $i.date('S', $time);
            }
            $options['MONDAY'] = 'EVERY MONDAY';
            $options['TUESDAY'] = 'EVERY TUESDAY';
            $options['WEDNESDAY'] = 'EVERY WEDNESDAY';
            $options['THURSDAY'] = 'EVERY THURSDAY';
            $options['FRIDAY'] = 'EVERY FRIDAY';
            $options['SATURDAY'] = 'EVERY SATURDAY';
            $options['SUNDAY'] = 'EVERY SUNDAY';
           
            $hourOptions=[];
            for($i=0; $i<24;++$i){
                $j = ($i>9) ? $i : "0$i";
                $time = strtotime("2015-01-01 $j:00:00");
                $hourOptions[$i] = date('ga', $time);
            }
            
            return View::make('administration.withdrawals.settings')->with( compact('setting', 'options','hourOptions', 'hour') );
        }

}