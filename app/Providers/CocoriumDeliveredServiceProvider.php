<?php namespace Delivered\Providers;

use Illuminate\Support\ServiceProvider;

class CocoriumDeliveredServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind('Delivered\Repositories\Client\ClientInterface','Delivered\Repositories\Client\ClientEloquentRepository');
	}

}
