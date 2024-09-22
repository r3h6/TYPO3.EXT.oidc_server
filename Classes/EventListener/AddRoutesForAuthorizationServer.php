<?php

declare(strict_types=1);

namespace R3H6\OidcServer\EventListener;

use R3H6\Oauth2Server\Event\ModifyAuthorizationServerRoutesEvent;
use R3H6\OidcServer\Controller\UserinfoController;
use Symfony\Component\Routing\Route;

/***
 *
 * This file is part of the "OIDC Server" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020
 *
 ***/

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
            null,
            'https',
            ['GET', 'POST']
        ));
    }
}
