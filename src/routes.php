<?php

use Slim\Http\Request;
use Slim\Http\Response;

$auth = new \WebDrink\Middleware\OIDCMiddleware();

//callback url for auth from oidc, mostly to strip the get vars
$app->get('/auth', function (Request $request, Response $response, array $args) {
    return $response->withRedirect('/');
})->add($auth);

//User route, this is the normal view
$app->get('/', function (Request $request, Response $response, array $args) {
    $provider = $request->getAttribute('provider');
    $user_info = $provider->requestUserInfo();

    $itemsAPI = new \WebDrink\API\Items();


    $info = [
        'username' => $user_info->preferred_username,
        'drinkadmin' => true,
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
            ],
            [
                'display_name' => 'lil dink',
                'slots' => [
                    [
                        'name' => "drink's choicey choice",
                        'price' => 1,
                        'enabled' => true,
                        'availible' => 1
                    ]
                ]
            ]
        ],
        'items' => $itemsAPI->listAll()

    ];


    return $this->view->render($response, 'index.twig', $info);
})->add($auth);

//api endpoints
$app->group('/api', function () use ($app) {
//    $app->group('/drops', function () use ($app) {
//        require __DIR__ . '/routes/drops.php';
//    });
    $app->group('/items', function () use ($app) {
        require __DIR__ . '/routes/items.php';
    });
    $app->group('/machines', function () use ($app) {
        require __DIR__ . '/routes/machines.php';
    });
//    $app->group('/temps', function () use ($app) {
//        require __DIR__ . '/routes/temps.php';
//    });
//    $app->group('/users', function () use ($app) {
//        require __DIR__ . '/routes/users.php';
//    });
});
