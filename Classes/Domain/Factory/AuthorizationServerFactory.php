<?php

namespace R3H6\OidcServer\Domain\Factory;

use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;

use OpenIDConnectServer\IdTokenResponse;
use R3H6\Oauth2Server\Configuration\Configuration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AuthorizationServerFactory extends \R3H6\Oauth2Server\Domain\Factory\AuthorizationServerFactory
{
    protected function getResponseType(Configuration $configuration): ?ResponseTypeInterface
    {
        if ($configuration['oidc']) {
            return GeneralUtility::makeInstance(IdTokenResponse::class);
        }
        return null;
    }
}
