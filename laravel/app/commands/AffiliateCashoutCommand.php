<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AffiliateCashoutCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cocorium:affiliate-cashout';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cronjob that handles affiliate balance cashout on 15th of the month';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * When a command should run
	 *
	 * @param Scheduler $scheduler
	 * @return \Indatus\Dispatcher\Scheduling\Schedulable
	 */
	public function schedule(Schedulable $scheduler)
	{
                $hour = Setting::firstOrCreate( [ 'name' => 'cashout-cron-hour' ] );
                $setting = Setting::firstOrCreate( [ 'name' => 'cashout-cron-date' ] );
                if($setting->value==''){
                    return $scheduler->daysOfTheMonth( [28] )->hours( 3 );
                }
                else{
                    if( !in_array($setting->value, ['MONDAY','TUESDAY','WEDNESDAY','THURSDAY','FRIDAY','SATURDAY','SUNDAY']) ){
                        return $scheduler->daysOfTheMonth( [$setting->value] )->hours( $hour->value );
                    }
                    else{
                        $day = strtoupper($setting->value);
                        switch( $day ){
                            case 'MONDAY': return $scheduler->daysOfTheWeek( [Scheduler::MONDAY ] )->hours( $hour->values ); break;
                            case 'TUESDAY': return $scheduler->daysOfTheWeek( [Scheduler::TUESDAY ] )->hours( $hour->values ); break;
                            case 'WEDNESDAY': return $scheduler->daysOfTheWeek( [Scheduler::WEDNESDAY ] )->hours( $hour->values ); break;
                            case 'THURSDAY': return $scheduler->daysOfTheWeek( [Scheduler::THURSDAY ] )->hours( $hour->values ); break;
                            case 'FRIDAY': return $scheduler->daysOfTheWeek( [Scheduler::FRIDAY ] )->hours( $hour->values ); break;
                            case 'SATURDAY': return $scheduler->daysOfTheWeek( [Scheduler::SATURDAY ] )->hours( $hour->values ); break;
                            case 'SUNDAY': return $scheduler->daysOfTheWeek( [Scheduler::SUNDAY ] )->hours( $hour->values ); break;
                        }
                    }
                }
		//return $scheduler;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
            //$affiliates = LTCAffiliate::where('affiliate_balance', '>=', Config::get( 'custom.cashout.threshold' ) )->get();
//            $cutoffDate = date( 'Y-m-01', strtotime('-1 month') );
            
            // reject any unprocessed transactions
            $affiliateRequests = Transaction::where('transaction_type','affiliate_debit')->where('status','pending')->lists('id');
            WithdrawalsHelper::reject( $affiliateRequests );
            
//            $cutoffDate = date( 'Y-m-01', strtotime('-1 day') );
            $d = date('Y-m-01');
            $cutoffDate = date( 'Y-m-d', strtotime($d.'-1 day') );
            
            $this->info("Cashout for purchases up until $cutoffDate");
            $testPurchases = [7044, 4403, 14, 8, 1];
            
            // get all affiliates that meet the threshold
            $affiliates = LTCAffiliate::whereHas('allTransactions', function($query) use ($cutoffDate, $testPurchases){
                $query->where('user_id','>',2)
                        ->where('transaction_type','affiliate_credit')
                        ->whereNull('cashed_out_on')->where('created_at', '<=', $cutoffDate )
                        ->where(function ($q) use ($testPurchases){
                                $q->whereNotIn( 'purchase_id', $testPurchases )
                                ->orWhereNull('purchase_id');                            
                            });
            })->get();
            foreach( $affiliates as $affiliate ){
                $this->info("Processing affiliate $affiliate->id");
                $transactions = $affiliate->allTransactions()->where('transaction_type','affiliate_credit')->whereNull('cashed_out_on')
                        ->where('created_at', '<=', $cutoffDate )
                        ->where(function ($q) use ($testPurchases){
                            $q->whereNotIn( 'purchase_id', $testPurchases )
                            ->orWhereNull('purchase_id');                            
                        })->get();
                $sum = $transactions->sum('amount'); 
                $this->info("AMT: $sum");
                
                
                $threshold = Config::get('custom.cashout.threshold');
                if( $affiliate->profile !=null && $affiliate->profile->payment_threshold > $threshold ){
                    $threshold = $affiliate->profile->payment_threshold;
                }
                
                if( $sum >= $threshold ){
                    if( !$affiliate->debit( $transactions->sum('amount'), null, $transactions ) ){
                        $this->error('Could not debit - '.$affiliate->debit_error);
                    }
                    else{
                        $this->comment('DEBITED!');
                    }
                }
                else{
                    $this->comment('Amount less than trashold. Not attempting cashout.');
                }
            }
	}

	

}
