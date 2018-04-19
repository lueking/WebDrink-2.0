<?php

use Slim\Http\Request;
use Slim\Http\Response;






$auth = new \WebDrink\Middleware\OIDCMiddleware();

//callback url for auth from oidc
$app->get('/auth', function (Request $request, Response $response, array $args){


    return $response->withRedirect('/');
})->add($auth);

//User route, this is the normal view
$app->get('/', function (Request $request, Response $response, array $args){

    return $response->withJson([$_SESSION['access_token']]);
})->add($auth);


//Where to go to get an API key
$app->get('/settings', function (Request $request, Response $response, array $args) {

});

//Secret drink admin things
$app->get('/admin', function (Request $request, Response $response, array $args) {

});


