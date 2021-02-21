<?php

namespace R3H6\OidcServer\Hooks;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use R3H6\OidcServer\Domain\Model\User;
use R3H6\OidcServer\Domain\Model\UserGetClaimsHookInterface;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;

final class RoleClaimHook implements UserGetClaimsHookInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function modifyClaims(&$claims, User $user)
    {
        $this->logger->debug('Add claim "Roles"');

        $claims['Roles'] = implode(', ', array_map(function (FrontendUserGroup $group) {
            return str_replace(',', ' ', $group->getTitle());
        }, $user->getUsergroup()->toArray()));
    }
}
