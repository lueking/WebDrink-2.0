<?php

use Slim\Http\Request;
use Slim\Http\Response;


// Routes

$app->add(new \WebDrink\Middleware\KeycloakMiddleware());


//User route, this is the normal view
$app->get('/', function (Request $request, Response $response, array $args) {
    $auth = $request->getAttribute('auth');

    $token = $auth->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    $user = $auth->getResourceOwner($token);

    return $response->withJson($user->getName());
    //return $this->renderer->render($response, 'index.twig', $args);
});


//Where to go to get an API key
$app->get('/settings', function (Request $request, Response $response, array $args) {

});

//Secret drink admin things
$app->get('/admin', function (Request $request, Response $response, array $args) {

});

