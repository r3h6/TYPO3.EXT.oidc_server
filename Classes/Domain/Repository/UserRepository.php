<?php
namespace R3H6\OidcServer\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use OpenIDConnectServer\Repositories\IdentityProviderInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

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
 * UserRepository
 */
final class UserRepository extends \TYPO3\CMS\Extbase\Persistence\Repository implements IdentityProviderInterface, LoggerAwareInterface
{

    use LoggerAwareTrait;

    public function initializeObject()
    {
        /** \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings $querySettings */
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    public function getUserEntityByIdentifier($identifier)
    {
        $this->logger->debug('Get user', ['identifier' => $identifier]);
        $this->initializeObject();

        $user = $this->findByUid($identifier);

        return $user;
    }
}
