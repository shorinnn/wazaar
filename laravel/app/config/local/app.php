<?php
return array(

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => true,
	'url' => 'http://wazaar.dev',
	'base_url' => 'wazaar.dev',
// 'url' => 'http://8698e2b3.ngrok.io',
// 'base_url' => '8698e2b3.ngrok.io',
        'locale' => 'en',
        'providers' => append_config(
		[
			'Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider',
			'Barryvdh\Debugbar\ServiceProvider',
                        'Way\Generators\GeneratorsServiceProvider',
                        'Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider',
		]
	)

);
