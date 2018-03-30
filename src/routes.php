<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->getContainer();


// Routes
$app->get('/', function (Request $request, Response $response, array $args) {

    $provider = new Stevenmaguire\OAuth2\Client\Provider\Keycloak([
        'authServerUrl' => 'sso.csh.rit.edu',
        'realm' => 'csh',
        'redirectUri' => 'webdrink-dev.csh.rit.edu'
    ]);

    if (!isset($_GET['code'])) {

        // If we don't have an authorization code then get one
        $authUrl = $provider->getAuthorizationUrl();
        $_SESSION['oauth2state'] = $provider->getState();
        header('Location: ' . $authUrl);
        exit;

    // Check given state against previously stored one to mitigate CSRF attack
    } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

        unset($_SESSION['oauth2state']);
        exit('Invalid state, make sure HTTP sessions are enabled.');

    } else {

        // Try to get an access token (using the authorization coe grant)
        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
        } catch (Exception $e) {
            exit('Failed to get access token: ' . $e->getMessage());
        }

        // Optional: Now you have a token you can look up a users profile data
        try {

            // We got an access token, let's now get the user's details
            $user = $provider->getResourceOwner($token);

            // Use these details to create a new profile
            printf('Hello %s!', $user->getName());

        } catch (Exception $e) {
            exit('Failed to get resource owner: ' . $e->getMessage());
        }

        // Use this to interact with an API on the users behalf
        return $response->withJson($token->getToken());
    }


    // Render index view
    //return $this->renderer->render($response, 'index.phtml', $args);

});

$app->group('/v2', function () use ($app) {
    $app->group('/test', function () use ($app) {
        require __DIR__ . '/api/v2/test.php';
    });
});


$app->group("/api", function (Request $request, Response $response, array $args) {
    $this->group("/drops", function (Request $request, Response $response, array $args) {
    });
    $this->group("/items", function (Request $request, Response $response, array $args) {
    });
    $this->group("/machines", function (Request $request, Response $response, array $args) {
    });
    $this->group("/users", function (Request $request, Response $response, array $args) {
    });
});
