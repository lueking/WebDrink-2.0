<?php

use Slim\Http\Request;
use Slim\Http\Response;


// Routes

$auth = new \WebDrink\Middleware\KeycloakMiddleware();

//User route, this is the normal view
$app->get('/', function (Request $request, Response $response, array $args) {
    $auth = $request->getAttribute('auth');

    return $response->withJson(var_export($auth));
    //return $this->renderer->render($response, 'index.twig', $args);
})->add($auth);

//Where to go to get an API key
$app->get('/settings', function (Request $request, Response $response, array $args) {

})->add($auth);

//Secret drink admin things
$app->get('/admin', function (Request $request, Response $response, array $args) {

})->add($auth);

