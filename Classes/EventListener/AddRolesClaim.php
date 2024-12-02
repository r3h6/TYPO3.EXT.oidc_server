<?php

declare(strict_types=1);

namespace R3H6\OidcServer\EventListener;

use R3H6\Oauth2Server\Domain\Model\FrontendUserGroup;
use R3H6\OidcServer\Event\ModifyUserClaimsEvent;

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

final class AddRolesClaim
{
    public function __invoke(ModifyUserClaimsEvent $event): void
    {
        $event->setClaims(array_merge($event->getClaims(), [
            'Roles' => implode(', ', array_map(fn(FrontendUserGroup $group): string => str_replace(',', ' ', $group->getTitle()), $event->getUser()->getUsergroup()->toArray())),
        ]));
    }
}
