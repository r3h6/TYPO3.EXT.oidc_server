<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Hooks;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use R3H6\Oauth2Server\Domain\Model\FrontendUserGroup;
use R3H6\OidcServer\Domain\Model\User;
use R3H6\OidcServer\Domain\Model\UserGetClaimsHookInterface;

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

final class RoleClaimHook implements UserGetClaimsHookInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function modifyClaims(array &$claims, User $user): void
    {
        $this->logger->debug('Add claim "Roles"');

        $claims['Roles'] = implode(', ', array_map(fn(FrontendUserGroup $group): string => str_replace(',', ' ', $group->getTitle()), $user->getUsergroup()->toArray()));
    }
}
