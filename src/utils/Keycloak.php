<?php

namespace WebDrink\Utils;

class Keycloak{

    private $provider;

    function __construct(){
        $this->provider = new \Stevenmaguire\OAuth2\Client\Provider\Keycloak([
            'authServerUrl' => OIDC_PROVIDER_URL,
            'realm' => OIDC_PROVIDER_REALM,
            'clientId' => OIDC_CLIENT_ID,
            'clientSecret' => OIDC_CLIENT_SECRET,
            'scope' => 'openid',
            'redirectUri' => 'https://webdrink-dev.csh.rit.edu/auth'
        ]);
    }

    function getProvider(){
        return $this->provider;
    }

    function isAuth(){

    }

    function authorize(){

    }


}