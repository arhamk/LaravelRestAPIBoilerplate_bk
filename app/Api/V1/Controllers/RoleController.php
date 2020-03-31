<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Role;
use App\Client;
use App\Api\V1\Requests\RoleRequest;
use App\Api\V1\Requests\FetchRequest;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class RoleController extends Controller
{
        /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->client_id = $request->client_id;
        $clientId = $request->client_id;
        if (Client::where('id', '=', $clientId)->exists()) {
           
            $role->save();
            $roleId = $role->id;
            return response()->json([
                'code' => 200,
                'data' => [
                    'role' => $roleId
                ]
            ]);
       
         }
         else
         {
            return response()->json([
                'code' => 422,
                'data' => [
                    'role' => 0
                ]
            ]);

         }
    }

    public function show(FetchRequest $request)
    {
        $id = $request->orderby;
        $roles = Role::find($id)->paginate(5);
        if($roles)
        {
                return response()->json([
                    'code' => 200,
                    'data' => [ 'list' => [
                            'data' => $roles,
                            'totalItems' => 44,
                            'totalPages' => 9,
                            'pages' => 1,
                            'limit' => 5
                        ]] ]);
         }
         else
         {
            return response()->json([
                'code' => 422,
                'data' => [ 'list' => [
                        'data' => 'No Record Exist',
                        'totalItems' => 0,
                        'totalPages' => 0,
                        'pages' => 0,
                        'limit' => 0
                    ]] ]);

         }

    }
}


