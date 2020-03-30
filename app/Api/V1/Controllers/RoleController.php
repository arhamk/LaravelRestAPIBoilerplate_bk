<?php

namespace App\Api\V1\Controllers;

use Illuminate\Support\Str;
use JWTAuth;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class RoleController extends Controller
{
        /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //die('in this method');

    
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'client_id' => 'required'
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $client->client_id = 1;
        

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