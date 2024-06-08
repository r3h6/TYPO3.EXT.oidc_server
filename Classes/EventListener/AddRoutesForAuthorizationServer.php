<?php

namespace R3H6\OidcServer\EventListener;

use R3H6\Oauth2Server\Event\ModifyAuthorizationServerRoutesEvent;
use R3H6\OidcServer\Controller\UserinfoController;
use Symfony\Component\Routing\Route;

final class AddRoutesForAuthorizationServer
{
    public function __invoke(ModifyAuthorizationServerRoutesEvent $event): void
    {
        $routes = $event->getRoutes();
        $routes->add('oidc_userinfo', new Route(
            '/userinfo',
            ['_controller' => UserinfoController::class . '::getClaims'],
            [],
            [],
            '',
            [],
            ['GET', 'POST']
        ));
    }
}
