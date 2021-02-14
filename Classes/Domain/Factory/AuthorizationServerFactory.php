<?php

namespace R3H6\OidcServer\Domain\Factory;

use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;

use OpenIDConnectServer\IdTokenResponse;
use R3H6\Oauth2Server\Configuration\Oauth2Configuration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AuthorizationServerFactory extends \R3H6\Oauth2Server\Domain\Factory\AuthorizationServerFactory
{
    protected function getResponseType(Oauth2Configuration $configuration): ?ResponseTypeInterface
    {
        return GeneralUtility::makeInstance(IdTokenResponse::class);
    }
}
