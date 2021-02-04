<?php
namespace R3H6\OidcServer\Domain\Factory;

use TYPO3\CMS\Core\SingletonInterface;
use OpenIDConnectServer\ClaimExtractor;
use R3H6\Oauth2Server\Domain\Configuration;
use OpenIDConnectServer\Entities\ClaimSetEntity;


class ClaimExtractorFactory implements SingletonInterface
{
    public function __invoke(Configuration $configuration)
    {
        $extractor = new ClaimExtractor();

        $claimSet = new ClaimSetEntity('role', [
            'Roles', // EXT:oidc
        ]);
        $extractor->addClaimSet($claimSet);

        return $extractor;
    }
}
