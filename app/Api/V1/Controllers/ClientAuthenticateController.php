<?php

namespace App\Api\V1\Controllers;

use App\Client;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use JWTAuth;
use Request;
use JWTFactory;


class ClientAuthenticateController extends Controller
{
    public function clientAuthenticate(Request $request){
        //$api_key = $request->header('Authorization');
        //$client = Client::whereApiKey($api_key)->first();
        $client = Request::get('client');

        $newArray = [
            'id' => $client->id,
            'type'=>'client',
            'api_key'=>$client->api_key,
            'uuid'=>$client->uuid,
        ];
        //JWTAuth::factory()->setTTL(JWTAuth::factory()->getTTL()*60);
        $customClaims = JWTFactory::customClaims($newArray);
        $payload = JWTFactory::make($newArray);
        $token = JWTAuth::encode($payload);

        /*JWTAuth::setToken($token);
        $token = JWTAuth::getToken();
        $decode = JWTAuth::decode($token);
        return $decode;*/
        //$token = JWTAuth::fromSubject($client);

        return response()->json([
            'code' => 200,
            'data' => ['token'=>$token->get()],
        ],200);
    }
}
