<?php

use Slim\Http\Request;
use Slim\Http\Response;


$auth = new \WebDrink\Middleware\AuthMiddleware();

//callback url for auth from keycloak
$app->get('/auth', function (Request $request, Response $response, array $args) use ($auth){

    //check to see if we're logged in already
    if(!$auth->needsAuth()){
        return $response->withRedirect('/');
    }

    //we need to have the code from OIDC
    if(empty($request->getAttribute('code'))){
        //if that's not set, just go back to start
        return $response->withRedirect('/');
    }

    $auth->setTokenFromAccessCode($request->getAttribute('code'));

    return $response->withRedirect('/');
});

//User route, this is the normal view
$app->get('/', function (Request $request, Response $response, array $args){
    $userinfo = $request->getAttribute('user_info');


    $ass = [
        "username" => $userinfo['username'],
        "drinkadmin" => $userinfo['drinkadmin'],
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

    //return $response->withJson($userinfo, null, true);
    return $this->renderer->render($response, 'index.twig', $ass);
})->add($auth);



//Where to go to get an API key
$app->get('/settings', function (Request $request, Response $response, array $args) {

})->add($auth);

//Secret drink admin things
$app->get('/admin', function (Request $request, Response $response, array $args) {

})->add($auth);


