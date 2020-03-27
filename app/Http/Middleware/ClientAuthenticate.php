<?php

namespace App\Http\Middleware;

use Closure;
use App\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientAuthenticate
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
        if($request->header('xt-api-key')){
            //$host = $request->getHost();
            $host = 'localhost';
            $api_key = $request->header('xt-api-key');
            try {
                $client = Client::whereHost($host)->whereApiKey($api_key)->whereEnable(true)->firstOrFail();
                $request->attributes->add(['client' => $client]);
                return $next($request);
            } catch (ModelNotFoundException $ex) {
                //return 'error';
            }
        }
        return response()->json([
            'error' => 'Unprocessable Entity',
            'message' => 'Invalid api key, or user does not exist',
            'code' => 422,
        ],422);
    }
}
