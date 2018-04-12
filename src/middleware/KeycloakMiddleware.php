<?php

namespace WebDrink\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;
use \Stevenmaguire\OAuth2\Client\Provider\Keycloak;

class KeycloakMiddleware {

    public function __invoke(Request $request, Response $response, $next) {
        $provider = new Keycloak([
            'authServerUrl' => OIDC_PROVIDER_URL,
            'realm' => OIDC_PROVIDER_REALM,
            'clientId' => OIDC_CLIENT_ID,
            'clientSecret' => OIDC_CLIENT_SECRET,
            'scope' => 'openid',
            'redirectUri' => 'https://webdrink-dev.csh.rit.edu/'
        ]);

        $provider->authorize();

        $request = $request->withAttribute('provider', $provider);

        return $next($request, $response);
    }



}