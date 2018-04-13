<?php

namespace WebDrink\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak;
use WebDrink\Utils\OIDC;

class AuthMiddleware {

    private $token;
    private $provider;

    public function __construct() {
        $this->provider = new Keycloak([
            'authServerUrl' => OIDC_PROVIDER_URL,
            'realm' => OIDC_PROVIDER_REALM,
            'clientId' => OIDC_CLIENT_ID,
            'clientSecret' => OIDC_CLIENT_SECRET,
            'scope' => 'openid',
            'redirectUri' => 'https://webdrink-dev.csh.rit.edu/auth'
        ]);
    }

    public function __invoke(Request $request, Response $response, $next) {

        //first step is making sure we have a code


        if(!is_null($this->token)){
            $this->provider->authorize();
        }



        $request = $request->withAttribute('auth', $auth);

        return $next($request, $response);
    }


    function (){

    }
}