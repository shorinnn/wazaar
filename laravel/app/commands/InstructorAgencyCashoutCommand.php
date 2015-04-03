<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstructorAgencyCashoutCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cocorium:instructor-agency-cashout';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cronjob that handles instructor agency balance cashout on 15th of the month';

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
            $cutoffDate = date( 'Y-m-01', strtotime('-1 month') );
            
            // get all affiliates that meet the threshold
            $agencies = InstructorAgency::whereHas('allTransactions', function($query) use ($cutoffDate){
                $query->where('transaction_type','instructor_agency_credit')->whereNull('cashed_out_on')->where('created_at', '<=', $cutoffDate );
            })->get();
            
            foreach( $agencies as $agency ){
                $transactions = $agency->allTransactions()->where('transaction_type','instructor_agency_credit')->whereNull('cashed_out_on')
                        ->where('created_at', '<=', $cutoffDate )->get();
                if( $transactions->sum('amount') >= Config::get('custom.cashout.threshold') ){
                    $agency->debit( $transactions->sum('amount'), null, $transactions );
                }
            }
	}

	

}
