<?php

namespace R3H6\OidcServer\Controller;

use League\OAuth2\Server\AuthorizationServer;


class TokenController extends \R3H6\Oauth2Server\Controller\TokenController
{
    public function __construct(AuthorizationServer $oidcServer)
    {
        parent::__construct($oidcServer);
    }
}
