<?php

namespace WebDrink\Middleware;

use League\OAuth2\Client\Token\AccessToken;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware {

    private $provider;

    public function __construct() {
        $keycloak = new \WebDrink\Utils\Keycloak();
        $this->provider = $keycloak->getProvider();
    }

    public function __invoke(Request $request, Response $response, $next) {

        //if we don't have a token, go get one
        if($this->needsAuth()){
            $this->provider->authorize();
            exit();
        }

        //save the token and the username
        $user = $this->provider->getResourceOwner($this->getToken());
        $request = $request->withAttribute('user_info', [
            'username' => $user->toArray()['preferred_username'],
            'drinkAdmin' => in_array('drink', $user->toArray()['groups'])
        ]);

        return $next($request, $response);
    }
    function setTokenFromAccessCode(String $code){
        $token = $this->provider->getAccessToken('authorization_code', [
            'code' => $code
        ]);
        $_SESSION['token'] = $token->jsonSerialize();
        $_SESSION['auth_user'] = $token->getResourceOwnerId();
    }

    function getProvider(){
        return $this->provider;
    }

    private function getToken(){
        return new AccessToken(json_decode($_SESSION['token'], true));
    }

    function needsAuth(){

        //do we have a token?
        if(isset($_SESSION['token'])){
            $token = null;

            //try to load the token from the session var.
            try {
                $token = $this->getToken();
            } catch (\Exception $ex) {
                unset($_SESSION['token']);
                return true;
            }

            //is that token expired?
            if($token->hasExpired()){
                //refresh and save the token
                $token = $this->provider->getAccessToken('refresh_token', ['refresh_token' => $token->getRefreshToken()]);
                $_SESSION['token'] = $token->jsonSerialize();
            }

            //make sure the token we have is for the right user
            if(strcmp($token->getResourceOwnerId(), $_SESSION['auth_user']) !== 0){
                //b&
                unset($_SESSION['token']);
                unset($_SESSION['auth_user']);
                return true;
            }

            return false;
        } else {
            return true;
        }
    }
}
