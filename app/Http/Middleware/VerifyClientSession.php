<?php namespace Delivered\Http\Middleware;

use Closure;

class VerifyClientSession {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if (\Session::has('clientId')) {
            return $next($request);
        }
        else{
            return response()->json(['success' => false, 'error' => 'Client ID not found. Cannot perform operation'],401);
        }
	}

}
