<?php

namespace R3H6\OidcServer\EventListener;

use OpenIDConnectServer\IdTokenResponse;
use R3H6\Oauth2Server\Event\BeforeAssembleAuthorizationServerEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class SetIdTokenResponseOnAuthorizationServer
{
    public function __invoke(BeforeAssembleAuthorizationServerEvent $event): void
    {
        if ($event->getConfiguration()['oidc'] ?? false) {
            $event->setResponseType(GeneralUtility::makeInstance(IdTokenResponse::class));
        }
    }
}
