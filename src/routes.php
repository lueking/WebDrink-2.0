<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes


$auth = new \WebDrink\Middleware\AuthMiddleware();

$app->get('/auth', function (Request $request, Response $response, array $args){
    return $response->withJson("snort");
})->add($auth);

//User route, this is the normal view
$app->get('/', function (Request $request, Response $response, array $args){
    return $response->withJson("bork");
})->add($auth);




//Where to go to get an API key
$app->get('/settings', function (Request $request, Response $response, array $args) {

});

//Secret drink admin things
$app->get('/admin', function (Request $request, Response $response, array $args) {

});


