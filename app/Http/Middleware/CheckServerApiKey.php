<?php

namespace App\Http\Middleware;

use Closure;

class CheckServerApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $api_key = $request->header('apiKey');

        // Check if the API key is in the api key array
        if ($api_key === \Config::get('onvp.serverapi_secret_key')) {
            return $next($request);
        }
        return response()->json(['status'=>'error', 'message' => 'Invalid API Key provided'], 403);
    }
}
