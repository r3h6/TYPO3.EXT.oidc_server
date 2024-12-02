<?php

declare(strict_types=1);

namespace R3H6\OidcServer\EventListener;

use OpenIDConnectServer\IdTokenResponse;
use R3H6\Oauth2Server\Event\BeforeAssembleAuthorizationServerEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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

final class SetIdTokenResponseOnAuthorizationServer
{
    public function __invoke(BeforeAssembleAuthorizationServerEvent $event): void
    {
        if ($event->getConfiguration()['oidc'] ?? false) {
            $event->setResponseType(GeneralUtility::makeInstance(IdTokenResponse::class));
        }
    }
}
