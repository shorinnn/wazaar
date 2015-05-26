<?php namespace Delivered\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'Delivered\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'Delivered\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'Delivered\Http\Middleware\RedirectIfAuthenticated',
        'client' => 'Delivered\Http\Middleware\VerifyClientMiddleware',
        'client.session' => 'Delivered\Http\Middleware\VerifyClientSession'
	];

}
