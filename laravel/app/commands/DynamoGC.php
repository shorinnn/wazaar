<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\ServiceProvider;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Session\SessionHandler;

class DynamoGCCommand extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cocorium:dynamo-gc';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cronjob that triggers DynamoDB garbage collection';

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
            
		return $scheduler->daily()->hours(3)->minutes(33);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
            $cfg = Config::get('session');
            if( !$cfg['dynamo_gc'] ) return false;
            
            $dynamoDb = DynamoDbClient::factory([
                'region' => $cfg['dynamo_aws_region'],
                'key'    =>  $cfg['dynamo_aws_key'],
                'secret' => $cfg['dynamo_aws_secret'],
            ]);
            
            $sessionHandler = SessionHandler::factory(array(
                'dynamodb_client' => $dynamoDb,
                'table_name'      => $cfg['table'],
                'hash_key'                 => $cfg['dynamo_hash'],
                'session_lifetime'         => $cfg['lifetime'] * 60,
                'consistent_read'          => true,
                'locking_strategy'         => null,
                'automatic_gc'             => false,
                'gc_batch_size'            => 25,
                'max_lock_wait_time'       => 10,
                'min_lock_retry_microtime' => 10000,
                'max_lock_retry_microtime' => 50000
            ));
            
            
            $res = $sessionHandler->garbageCollect();
	}

	

}
