<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Domain\Factory;

use OpenIDConnectServer\ClaimExtractor;
use OpenIDConnectServer\Entities\ClaimSetEntity;
use R3H6\Oauth2Server\Configuration\Configuration;

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

class ClaimExtractorFactory
{
    public function __invoke(Configuration $configuration): ClaimExtractor
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
