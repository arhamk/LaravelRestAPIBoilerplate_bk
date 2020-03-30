<?php

namespace App\Api\V1\Controllers;

use Illuminate\Support\Str;
use JWTAuth;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class ClientController extends Controller
{
        /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //die('in this method');
        $apiKey = rand();
        $api_key = md5($apiKey);
    
        $this->validate($request, [
            'host' => 'required',
            'number' => 'required'
        ]);

        $client = new Client();
        $client->host = $request->host;
        $client->number = $request->number;
        $client->api_key = $api_key;
        $client->uuid = Str::uuid();

        if ($client->save())
        {
            return response()->json([
                'success' => true,
                'client' => $client
            ]);
        }   
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, client could not be added.'
            ], 500);
        }    
    }




}