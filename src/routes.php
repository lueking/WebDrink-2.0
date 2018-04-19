<?php

use Slim\Http\Request;
use Slim\Http\Response;

$auth = new \WebDrink\Middleware\OIDCMiddleware();

//callback url for auth from oidc, mostly to strip the get vars
$app->get('/auth', function (Request $request, Response $response, array $args){
    return $response->withRedirect('/');
})->add($auth);

//User route, this is the normal view
$app->get('/', function (Request $request, Response $response, array $args){
    $provider = $request->getAttribute('provider');
    $user_info = $provider->requestUserInfo();

    $info = [
        'username' => $user_info->preferred_username,
        'drinkadmin' => in_array('drink', $user_info->groups),
        'credits' => 420,
        'machines' => [
            [
                'display_name' => 'big dronk',
                'slots' => [
                    [
                        'name' => 'baaallls',
                        'price' => 9001,
                        'enabled' => true,
                        'availible' => 1
                    ]
                ]
            ]
        ]

    ];


    return $this->view->render($response, 'index.twig', $info);
})->add($auth);


//Where to go to get an API key
$app->get('/settings', function (Request $request, Response $response, array $args) {

});

//Secret drink admin things
$app->get('/admin', function (Request $request, Response $response, array $args) {

});


