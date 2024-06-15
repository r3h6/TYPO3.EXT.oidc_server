<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Domain\Repository;

use OpenIDConnectServer\Repositories\IdentityProviderInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;

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
 * @extends \TYPO3\CMS\Extbase\Persistence\Repository<\R3H6\OidcServer\Domain\Model\User>
 */
final class UserRepository extends Repository implements IdentityProviderInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function initializeObject(): void
    {
        /** \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings $querySettings */
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param int|string|null $identifier
     * @return \R3H6\OidcServer\Domain\Model\User|null
     */
    public function getUserEntityByIdentifier($identifier)
    {
        $this->logger->debug('Get user', ['identifier' => $identifier]);
        return $this->findByIdentifier((int)$identifier);
    }
}
