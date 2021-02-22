<?php

declare(strict_types=1);
namespace R3H6\OidcServer\Domain\Factory;

use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use OpenIDConnectServer\IdTokenResponse;
use R3H6\Oauth2Server\Configuration\Configuration;
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

/**
 * AuthorizationServerFactory
 */
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
