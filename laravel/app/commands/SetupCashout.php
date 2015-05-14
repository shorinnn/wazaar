<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SetupCashoutCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cocorium:setup-cashout';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Deletes all transactions and sets up 1 approved withdrawal for the "instructor" user';

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
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
            $instructor = Instructor::where('username', 'instructor')->first();
            Transaction::truncate();
            Transaction::unguard();
            $t = date('Y-m-01', strtotime('-40 day') );
            Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
                'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
            Transaction::create([ 'user_id' => $instructor->id, 'transaction_type' => 'instructor_credit', 'amount' => 50, 'product_id' => 1, 
                'product_type' => 'Course', 'status' => 'complete', 'created_at' => $t ]);
            $instructor->instructor_balance = 100;
            $instructor->updateUniques();
            Artisan::call( 'cocorium:instructor-cashout' );
            DB::table('transactions')->update( ['status' => 'complete'] );
	}

	

}
