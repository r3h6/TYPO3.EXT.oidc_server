<?php
namespace R3H6\OidcServer\Domain\Factory;

use OpenIDConnectServer\IdTokenResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use R3H6\Oauth2Server\Configuration\RuntimeConfiguration;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;

class AuthorizationServerFactory extends \R3H6\Oauth2Server\Domain\Factory\AuthorizationServerFactory
{
    public function __invoke(RuntimeConfiguration $configuration)
    {
        return parent::__invoke($configuration);
    }

    protected function getResponseType(): ?ResponseTypeInterface
    {
        return GeneralUtility::makeInstance(IdTokenResponse::class);
    }
}
