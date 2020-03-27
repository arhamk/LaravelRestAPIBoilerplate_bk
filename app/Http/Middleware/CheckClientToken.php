<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class CheckClientToken
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
        $token = $request->bearerToken();
        $token = $request->header('xt-client-token');
        if($token){
            try{
                /*JWTAuth::setToken($token);
                //$token = JWTAuth::parseToken()->getPayload();
                $payload = JWTAuth::parseToken()->getPayload();*/
                JWTAuth::setToken($token);
                $token = JWTAuth::getToken();
                $payload = JWTAuth::decode($token);
                //if($payload->get('id') && $payload->get('api_key') && $payload->get('type') === 'client'){
                if($payload['id'] && $payload['api_key'] && $payload['type'] === 'client'){
                    $clientArray = [
                        'id' => $payload['id'],
                        'api_key' => $payload['api_key'],
                        'type' => $payload['type'],
                    ];
                    $request->attributes->add(['client' => $clientArray]);
                    return $next($request);
                }

                return response()->json([
                    'statusCode' => 500,
                    'error' => 'Internal Server Error',
                    'message' => 'invalid token',
                ],500);

            }catch (TokenInvalidException $ex){

                return response()->json([
                    'statusCode' => 500,
                    'error' => 'Internal Server Error',
                    'message' => 'invalid signature',
                ],500);

            }

        }

        return response()->json([
            'statusCode' => 500,
            'code' => 'ERR_ASSERTION',
            'error' => 'Internal Server Error',
            'message' => 'missing token',
        ],500);

    }
}
