<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\JWTAuth;
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
        if($token){
            try{
                $token = JWTAuth::parseToken()->getPayload();
                $payload = JWTAuth::parseToken()->getPayload();
                if($payload->get('id') && $payload->get('api_key') && $token->get('type') === 'client'){
                    $clientArray = [
                        'id' => $payload->get('id'),
                        'api_key' => $payload->get('api_key'),
                        'type' => $payload->get('type'),
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
