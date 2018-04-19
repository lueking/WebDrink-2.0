<?php

namespace WebDrink\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;


use WebDrink\Utils\OIDC;

class OIDCMiddleware {
    public function __invoke(Request $request, Response $response, $next) {
        // Makes route Require Auth
        $oidc = new OIDC();
        $providerClient = $oidc->getAuth();

        //if we have an access token, then we're good.
        if(!isset($_SESSION['access_token']) && $providerClient->authenticate() ){
            $oidc->saveToken();
        }
        $providerClient->setAccessToken($_SESSION['access_token']);

        $request = $request->withAttribute('provider', $providerClient);

        return $next($request, $response);
    }
}