<?php

class WithdrawalsController extends \BaseController {
    
        public function __construct(){
            $this->beforeFilter('admin');
            $this->beforeFilter('csrf', ['only' => [ 'update','destroy' ]]);
        }


	public function index()
	{
                $types = [ 'instructor_agency_debit', 'instructor_debit', 'affiliate_debit' ];
		$requests = Transaction::whereIn('transaction_type',$types)->where('status','pending')->paginate( 20 );
                if( Request::ajax() ){
                    return View::make('administration.withdrawals.partials.table')->with( compact('requests') );
                }
                return View::make('administration.withdrawals.index')->with( compact('requests') );
	}
        
        public function store()
	{
                $types = [ 'instructor_agency_debit', 'instructor_debit', 'affiliate_debit' ];
		$requests = Transaction::whereIn('transaction_type',$types)->where('status','pending')->paginate( 20 );
                
                header('Content-Type: text/csv; charset=UTF-8');
                $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
                $csv->setEncodingFrom('iso-8859-15');
	            
	            $csv_headers = [
	            	'#', trans('profile.form.lastName'),  trans('profile.form.firstName'), trans('profile.form.email'),
                        trans('administration.amount'), 'Bank Details Status',  trans('profile.form.bank-code'),  trans('profile.form.bank-name'),
                        trans('profile.form.branch-code'), trans('profile.form.branch-name'), trans('profile.form.account-type'),
                        trans('profile.form.account-number'), trans('profile.form.beneficiary-name')
                        
	            ];
	            $csv->insertOne($csv_headers);
	            $id = 1;
                    foreach($requests as $request){
                            if( $request->transaction_type=='instructor_debit'){
                                $profile = $request->user->_profile('Instructor');
                                $status = $request->user->noFill('Instructor') ? 'No Fill' : 'Filled in';
                            }
                            else{
                                $request->user->_profile('Affiliate');
                                $status = $request->user->noFill('Affiliate') ? 'No Fill' : 'Filled in';
                            }
                            $row_data = array();
                            $row_data[] = $profile->last_name or '';
                            $row_data[] = $profile->first_name or '';
                            $row_data[] = $profile->email or '';
                            $row_data[] = $request->amount;
                            $row_data[] = $status;
                            $row_data[] = $profile->bank_code;
                            $row_data[] = $profile->bank_name;
                            $row_data[] = $profile->branch_code;
                            $row_data[] = $profile->branch_name;
                            $row_data[] = $profile->account_type;
                            $row_data[] = $profile->account_number;
                            $row_data[] = $profile->beneficiary_name;
                            $csv->insertOne( $row_data );
                            ++$id;
                    }

	            $csv->output('withdrawals.csv');
	            exit();
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