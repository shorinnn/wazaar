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
            // get all affiliates that meet the threshold
            $affiliates = LTCAffiliate::where('affiliate_balance', '>=', Config::get( 'custom.cashout.threshold' ) )->get();
            foreach( $affiliates as $affiliate ){
                $affiliate->debit( $affiliate->affiliate_balance );
            }
	}

	

}