<?php

namespace R3H6\OidcServer\Controller;

use League\OAuth2\Server\AuthorizationServer;
use R3H6\Oauth2Server\Domain\Repository\UserRepository;


class AuthorizationController extends \R3H6\Oauth2Server\Controller\AuthorizationController
{
    public function __construct(AuthorizationServer $oidcServer, UserRepository $userRepository)
    {
        parent::__construct($oidcServer, $userRepository);
    }
}
