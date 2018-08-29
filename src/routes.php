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

    $machinesAPI = new \WebDrink\API\Machines();

    $ldap = new WebDrink\Utils\LDAP();

    $data = $ldap->ldap_lookup_uid($user_info->preferred_username, ['drinkBalance']);

    $info = [
        'username' => $user_info->preferred_username,
        'drinkadmin' => in_array("drink", $user_info->groups),
        'credits' => $data,
        'machines' => $machinesAPI->getAllMachinesWithSlots(),
        'user' => var_export($user_info)
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
