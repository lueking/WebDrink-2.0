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
        if(empty($request->getAttribute('code')) && empty($this->token)){
            $this->provider->authorize();
            exit();
        }
        //then, we should get a token from our code
        if(empty($this->token)){
            $this->token = $this->provider->getAccessToken('authorization_code', ['code' => $request->getAttribute('code')]);
        }
        //need to check if we need to renew our token
        if($this->token->hasExpired()) {
            $this->token = $this->provider->getAccessToken('refresh_token', ['refresh_token' => $this->token->getRefreshToken()]);
        }

        //save the token and the username
        $request = $request->withAttribute('userdata', [
            "token" => $this->token,
            "userinfo" => $this->provider->getResourceOwner($this->token)
        ]);


        return $next($request, $response);
    }
}