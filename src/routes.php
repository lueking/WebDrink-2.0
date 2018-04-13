<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes


$auth = new \WebDrink\Middleware\AuthMiddleware();

//User route, this is the normal view
$app->get('/', function (Request $request, Response $response, array $args){
    $auth = $request->getAttribute('auth');

    $ass = [
        "username" => $auth->requestUserInfo('preferred_username'),
        "drinkadmin" => in_array('drink', $auth->requestUserInfo('groups'))
    ];

    return $response->withJson($ass, null, true);
    //return $this->renderer->render($response, 'index.twig', $args);
})->add($auth);


//Where to go to get an API key
$app->get('/settings', function (Request $request, Response $response, array $args) {

});

//Secret drink admin things
$app->get('/admin', function (Request $request, Response $response, array $args) {

});


