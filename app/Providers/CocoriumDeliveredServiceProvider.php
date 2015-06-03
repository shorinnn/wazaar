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
        $this->app->bind('Delivered\Repositories\Template\TemplateInterface','Delivered\Repositories\Template\TemplateEloquentRepository');
        $this->app->bind('Delivered\Repositories\EmailRequest\EmailRequestInterface','Delivered\Repositories\EmailRequest\EmailRequestEloquentRepository');
        $this->app->bind('Delivered\Repositories\ClientUser\ClientUserInterface','Delivered\Repositories\ClientUser\ClientUserEloquentRepository');
	}

}
