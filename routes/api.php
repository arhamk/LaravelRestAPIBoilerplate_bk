<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    /*$api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');


        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');


     

    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });*/

    //Mz Routes
    $api->group(['middleware' => 'client.authenticate'], function(Router $api) {
        $api->get('authenticate', 'App\\Api\\V1\\Controllers\\ClientAuthenticateController@clientAuthenticate');
    });

    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->group(['middleware' => 'check.client.token'], function(Router $api) {
            $api->post('user', 'App\\Api\\V1\\Controllers\\LoginController@user');
        });

        //Validated Area
        $api->group(['middleware' => 'jwt.my.auth'], function(Router $api) {
            $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
            $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');
        });
    });

    // arham routes
    $api->group(['prefix' => 'backend'], function(Router $api) {
        $api->group(['prefix' => 'client'], function(Router $api) {
            $api->post('create', 'App\\Api\\V1\\Controllers\\ClientController@store');
        });

        $api->group(['prefix' => 'user'], function(Router $api) {
            $api->post('create', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        });

        $api->group(['prefix' => 'permission'], function(Router $api) {
            $api->get('roles/{permissionId}', 'App\\Api\\V1\\Controllers\\PermissionController@viewGroupName');
        });
        $api->group(['prefix' => 'roles'], function(Router $api) {
            $api->post('create', 'App\\Api\\V1\\Controllers\\RoleController@signUp');
        });


    });


    });


    Route::any('{path}', function() {
        return response()->json([
            'message' => 'Route '.request()->method().':/' . request()->path() .' not found',
            'error' => 'Not Found',
            'statusCode' => 404,
        ], 404);
    })->where('path', '.*');

});
