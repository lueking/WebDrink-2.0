<?php

namespace WebDrink\Utils;

use Jumbojett\OpenIDConnectClient;

class OIDC {

    private $oidc;

    public function __construct() {
        $this->oidc = new OpenIDConnectClient(OIDC_PROVIDER_URL, OIDC_CLIENT_ID, OIDC_CLIENT_SECRET);
        $this->oidc->addScope('openid');
        $this->oidc->setRedirectURL('https://webdrink-dev.csh.rit.edu/');
    }

    public function getAuth() {
        return $this->oidc;
    }

    public function saveToken(){
        $_SESSION['access_token'] = $this->oidc->getAccessToken();
        $_SESSION['token_info'] =$this->oidc->getTokenResponse();
    }
}
