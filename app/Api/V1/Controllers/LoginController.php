<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;
use Request;

class LoginController extends Controller
{
    public function user(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $client = Request::get('client');
        $credentials = $request->only(['username', 'password']);
        $credentials['enable'] = true;
        //$credentials['client_id'] = $client['id'];
        try {
            $token = Auth::guard()->attempt($credentials);

            if(!$token) {
                return response()->json([
                    'error' => 'Unprocessable Entity',
                    'message' => 'Invalid username or password',
                    'code' => 422,
                ],422);
            }

        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        $userId = auth()->user()->id;
        $user = \App\User::with(['roles'=>function($q){
            $q->with(['permissions'=>function($q){

            }]);
        }])->find($userId);

        $userPermission = $user->roles->mapWithKeys(function($role) {
            return $role->permissions;
        });

        $permissionRuleSet = $userPermission->mapWithKeys(function ($permission){
            return json_decode($permission->rule_set);
        });

        $permissionRuleSet = $permissionRuleSet->map(function ($permissionRuleSet) use ($userPermission){
            return $userPermission[0]->method .':'.$permissionRuleSet;
        });

        return response()
            ->json([
                'code' => 200,
                'data' => [
                    'token' => $token,
                    'user' => auth()->user()->only('id', 'number', 'email', 'enable'),
                    'acl' => $permissionRuleSet
                ],
            ],200);
    }
}
