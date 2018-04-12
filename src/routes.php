<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->group('', function (Request $request, Response $response, array $args) use ($app) {

    $auth = new \WebDrink\Middleware\AuthMiddleware();

    //User route, this is the normal view
    $app->get('/', function (Request $request, Response $response, array $args){
        return $response->withJson('/');
    })->add($auth);

    $app->get('/auth', function (Request $request, Response $response, array $args){
        return $response->withJson('/auth');
    })->add($auth);


//Where to go to get an API key
    $app->get('/settings', function (Request $request, Response $response, array $args) {

    });

//Secret drink admin things
    $app->get('/admin', function (Request $request, Response $response, array $args) {

    });
});


