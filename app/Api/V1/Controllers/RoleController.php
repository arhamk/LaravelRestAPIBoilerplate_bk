<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Role;
use App\Client;
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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'client_id' => 'required'
        ]);
      
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
    }

    public function show(Request $request)
    {
        $id = $request->orderby;
        $roles = Role::find($id)->paginate(5);
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
}


