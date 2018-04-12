<?php

use Slim\Http\Request;
use Slim\Http\Response;


// Routes



//User route, this is the normal view
$app->get('/', function (Request $request, Response $response, array $args) {
    $auth = new \WebDrink\Middleware\KeycloakMiddleware();

    return $response->withJson(var_export($auth));
    //return $this->renderer->render($response, 'index.twig', $args);
});

//Where to go to get an API key
$app->get('/settings', function (Request $request, Response $response, array $args) {

});

//Secret drink admin things
$app->get('/admin', function (Request $request, Response $response, array $args) {

});

