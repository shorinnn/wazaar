<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class StudentBalanceDebitRefundCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cocorium:student-balance-debit-refund';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cronjob that refunds credit taken from subjects and not used (i.e. transaction failed/cancelled)';

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
            // get all non-used balance debit transactions, older than 24h
            $yesterday = date( 'Y-m-d H:i:s', strtotime( date('Y-m-d H:i:s').' -24 hour' ) );
            $transactions = Transaction::where('transaction_type','student_balance_debit')
                    ->where('status', 'pending')
                    ->where('created_at', '<=', $yesterday )->get();
            foreach( $transactions as $transaction ){
                $student = Student::find( $transaction->user_id );
                $student->refundBalanceDebit( $transaction );
            }
	}

	

}
