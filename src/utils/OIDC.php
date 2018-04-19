<?php

namespace WebDrink\Utils;

use Jumbojett\OpenIDConnectClient;

class OIDC {

    private $oidc;

    public function __construct() {
        $this->oidc = new OpenIDConnectClient(OIDC_PROVIDER_URL, OIDC_CLIENT_ID, OIDC_CLIENT_SECRET);
        $this->oidc->addScope('openid');
        $this->oidc->setRedirectURL('https://webdrink-dev.csh.rit.edu/auth');
    }

    public function getAuth() {
        return $this->oidc;
    }
}
