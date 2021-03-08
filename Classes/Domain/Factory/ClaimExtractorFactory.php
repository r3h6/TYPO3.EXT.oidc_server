<?php

declare(strict_types=1);
namespace R3H6\OidcServer\Domain\Factory;

use OpenIDConnectServer\ClaimExtractor;
use OpenIDConnectServer\Entities\ClaimSetEntity;
use R3H6\Oauth2Server\Configuration\Configuration;
use TYPO3\CMS\Core\SingletonInterface;

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
 * ClaimExtractorFactory
 */
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
