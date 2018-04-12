<?php

namespace WebDrink\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;
use WebDrinkAPI\Utils\OIDC;

class AuthMiddleware {
    public function __invoke(Request $request, Response $response, $next) {
            // Makes route Require Auth
            $oidc = new OIDC();
            $auth = $oidc->getAuth();
            $auth->authenticate();

            $request = $request->withAttribute('auth', $auth);

            return $next($request, $response);
    }
}