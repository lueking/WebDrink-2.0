<?php

use Slim\Http\Request;
use Slim\Http\Response;




//callback url for auth from oidc
$app->get('/auth', function (Request $request, Response $response, array $args){
    return $response->withJson('redirected ass');
});

$auth = new \WebDrink\Middleware\OIDCMiddleware();

//User route, this is the normal view
$app->get('/', function (Request $request, Response $response, array $args){

    $auth = $request->getAttribute('auth');

    $access_token = $auth->getAccessToken();
    $token_response = $auth->getTokenResponse();

    return $response->withJson([$access_token, $token_response]);
})->add($auth);


//Where to go to get an API key
$app->get('/settings', function (Request $request, Response $response, array $args) {

});

//Secret drink admin things
$app->get('/admin', function (Request $request, Response $response, array $args) {

});


