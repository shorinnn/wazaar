<?php namespace Delivered\Http\Middleware;

use Closure;
use Delivered\Helpers\ClientAuthHelper;

class VerifyClientMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

        if (!$request->has('apiKey'))
        {
            return response()->json(['success' => false, 'error' => 'API Key was not provided'],401);
        }

        if (!$request->has('token'))
        {
            return response()->json(['success' => false, 'error' => 'Token was not provided'],401);
        }

        $authHelper = new ClientAuthHelper();

        $verifier = $authHelper->authenticate($request->get('apiKey'),$request->get('token'));

        if ($verifier === true){
            return $next($request);
        }

        return response()->json(['success' => false, 'error' => $verifier],401);
	}

}
