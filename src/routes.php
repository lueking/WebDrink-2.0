<?php

use Slim\Http\Request;
use Slim\Http\Response;


$app->add(new \WebDrink\Middleware\AuthMiddleware());

//User route, this is the normal view
$app->get('/', function (Request $request, Response $response, array $args){
    $userinfo = $request->getAttribute('userdata')['userinfo'];


    $ass = [
        "username" => "butts",
        "drinkadmin" => false,
        "credits" => 420,
        "machines" => [
            "big" => [
                "slots" => [
                    [
                        "price" => 69,
                        "name" => "urmom",
                        "enabled" => "true",
                        "status" => "true",
                        "availible" => "true"

                    ],
                    [
                        "price" => 999,
                        "name" => "urdad",
                        "enabled" => "false",
                        "status" => "true",
                        "availible" => "true"
                    ]
                ],
                "display_name" => "big boy"
            ],
        ]
    ];

    return $response->withJson($userinfo, null, true);
    //return $this->renderer->render($response, 'index.twig', $args);
});

//callback url for auth? that we just use to get rid of those nasty get vars
$app->get('/auth', function (Request $request, Response $response, array $args) {
    $response->withRedirect('/');
});

//Where to go to get an API key
$app->get('/settings', function (Request $request, Response $response, array $args) {

});

//Secret drink admin things
$app->get('/admin', function (Request $request, Response $response, array $args) {

});


