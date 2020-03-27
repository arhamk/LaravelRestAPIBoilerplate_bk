<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use JWTAuth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $headerParser = new \Tymon\JWTAuth\Http\Parser\AuthHeaders;
        $headerParser->setHeaderName('xt-user-token'); // though HTTP headers are case-insensitive so case shouldn't matter
        $headerParser->setHeaderPrefix(''); // though HTTP headers are case-insensitive so case shouldn't matter
        JWTAuth::parser()->setChain([$headerParser]);

        $this->registerPolicies();
        //

    }
}
