<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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

        return response()
            ->json([
                'code' => 200,
                'data' => [
                    'token' => $token,
                    'user' => auth()->user()->only('id', 'number', 'email', 'enable'),
                    'acl' => []
                ],
            ],200);
    }
}
