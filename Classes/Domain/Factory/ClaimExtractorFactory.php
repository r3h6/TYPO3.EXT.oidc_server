<?php

namespace R3H6\OidcServer\Domain\Factory;

use OpenIDConnectServer\ClaimExtractor;
use OpenIDConnectServer\Entities\ClaimSetEntity;
use R3H6\Oauth2Server\Configuration\Configuration;
use TYPO3\CMS\Core\SingletonInterface;

class ClaimExtractorFactory implements SingletonInterface
{
    public function __invoke(Configuration $configuration)
    {
        $extractor = new ClaimExtractor();

        $claimSets = (array)($configuration['claimSets'] ?? []);
        foreach ($claimSets as $scope => $claims) {
            $claimSet = new ClaimSetEntity($scope, $claims);
            $extractor->addClaimSet($claimSet);
        }

        return $extractor;
    }
}
