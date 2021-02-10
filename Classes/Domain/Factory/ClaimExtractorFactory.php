<?php
namespace R3H6\OidcServer\Domain\Factory;

use TYPO3\CMS\Core\SingletonInterface;
use OpenIDConnectServer\ClaimExtractor;
use OpenIDConnectServer\Entities\ClaimSetEntity;
use R3H6\Oauth2Server\Configuration\RuntimeConfiguration;


class ClaimExtractorFactory implements SingletonInterface
{
    public function __invoke(RuntimeConfiguration $configuration)
    {
        $extractor = new ClaimExtractor();

        $claimSets = (array) ($configuration->get('claimSets') ?? []);
        foreach ($claimSets as $scope => $claims) {
            $claimSet = new ClaimSetEntity($scope, $claims);
            $extractor->addClaimSet($claimSet);
        }

        return $extractor;
    }
}
