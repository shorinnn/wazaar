<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstructorCashoutCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cocorium:instructor-cashout';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cronjob that handles instructor balance cashout on 15th of the month';

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
		//return $scheduler->daysOfTheMonth( [15] )->hours( 3 );
		return $scheduler;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
            // get all instructors that meet the threshold
            //$instructors = Instructor::where('instructor_balance', '>=', Config::get( 'custom.cashout.threshold' ) )->get();
            
            $cutoffDate = date( 'Y-m-01', strtotime('-1 month') );
            
            $instructors = Instructor::whereHas('allTransactions', function($query) use ($cutoffDate){
                $query->where('user_id','>', 2)->whereIn('transaction_type',['instructor_credit','second_tier_instructor_credit'])
                        ->whereNull('cashed_out_on')->where('created_at', '<=', $cutoffDate );
            })->get();
            
            foreach( $instructors as $instructor ){
                $transactions = $instructor->allTransactions()->whereIn('transaction_type',['instructor_credit','second_tier_instructor_credit'])
                        ->whereNull('cashed_out_on')->where('created_at', '<=', $cutoffDate )->get();
                if( $transactions->sum('amount') >= Config::get('custom.cashout.threshold') ){
                    $instructor->debit( $transactions->sum('amount'), null, $transactions );
                }
            }
	}

	

}
