<?php namespace Cocorium;

use Illuminate\Support\ServiceProvider;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Session\SessionHandler;
use Session;

class DynamoSessionServiceProvider extends ServiceProvider {
    const DEFAULT_REGION = 'us-east-1';

    // Make sure that this service provider always boots
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
       Session::extend('dynamo', function ($app) {
            // Get a shortcut to config data            
            $cfg = $app['config']->get('session');
            // Do the real work of hooking up Dynamo as session handler
            $dynamoDb = DynamoDbClient::factory([
                'region' => (isset($cfg['dynamo_aws_region']) ? $cfg['dynamo_aws_region'] : self::DEFAULT_REGION),
                'key'    =>  $cfg['dynamo_aws_key'],
                'secret' => $cfg['dynamo_aws_secret'],
            ]);
            
            
            $sessionHandler = $dynamoDb->registerSessionHandler([
                'table_name'               => $cfg['table'],
                'hash_key'                 => $cfg['dynamo_hash'],
                'session_lifetime'         => $cfg['lifetime'],
                'consistent_read'          => true,
                'locking_strategy'         => null,
                'automatic_gc'             => false,
                'gc_batch_size'            => 25,
                'max_lock_wait_time'       => 10,
                'min_lock_retry_microtime' => 10000,
                'max_lock_retry_microtime' => 50000
            ]);

            // Set the start of the session id to the cookie name - optional
            $sessionHandler->open('', $cfg['cookie']);

            return $sessionHandler;
        });
    }
}