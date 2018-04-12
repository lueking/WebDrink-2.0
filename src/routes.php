<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Stevenmaguire\OAuth2\Client\Provider\Keycloak;


// Routes


$provider = new Keycloak([
    'authServerUrl' => OIDC_PROVIDER_URL,
    'realm' => OIDC_PROVIDER_REALM,
    'clientId' => OIDC_CLIENT_ID,
    'clientSecret' => OIDC_CLIENT_SECRET,
    'scope' => 'openid',
    'redirectUri' => 'https://webdrink-dev.csh.rit.edu/auth'
]);

//User route, this is the normal view
$app->get('', function (Request $request, Response $response, array $args) use ($provider){

    if (is_null( $request->getAttribute('code'))) {
        $provider->authorize();
    }

    return $response->withJson("derp");
    //return $this->renderer->render($response, 'index.twig', $args);
});

$app->get('/auth', function (Request $request, Response $response, array $args) use ($provider){

    if (empty($request->getAttribute('state')) || ($request->getAttribute('state') !== $_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
        $provider->authorize();
    } else {

        // Try to get an access token (using the authorization coe grant)
        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $request->getAttribute('state')
            ]);
        } catch (Exception $e) {
            exit('Failed to get access token: ' . $e->getMessage());
        }

            // We got an access token, let's now get the user's details
            $user = $provider->getResourceOwner($token);

        // Use this to interact with an API on the users behalf
       return $response->withJson($user->getName());
    }
});


//Where to go to get an API key
$app->get('/settings', function (Request $request, Response $response, array $args) {

});

//Secret drink admin things
$app->get('/admin', function (Request $request, Response $response, array $args) {

});

