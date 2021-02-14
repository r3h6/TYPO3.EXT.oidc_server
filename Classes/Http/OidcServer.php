<?php

namespace R3H6\OidcServer\Http;

use R3H6\Oauth2Server\Domain\Factory\AuthorizationServerFactory;
use R3H6\Oauth2Server\Http\Oauth2Server;
use R3H6\OidcServer\Controller\UserinfoController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class OidcServer extends Oauth2Server
{
    public function __construct(AuthorizationServerFactory $oidcAuthorizationServerFactory)
    {
        parent::__construct($oidcAuthorizationServerFactory);
    }

    protected function getRoutes(): RouteCollection
    {
        $routes = parent::getRoutes();
        $routes->add(
            'oidc_userinfo',
            (new Route('/userinfo'))
                ->setDefaults(['controller' => UserinfoController::class . '::approveAuthorization'])
                ->setMethods(['POST'])
        );
        return $routes;
    }
}
