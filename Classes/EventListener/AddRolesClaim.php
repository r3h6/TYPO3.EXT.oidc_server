<?php

namespace R3H6\OidcServer\EventListener;

use R3H6\Oauth2Server\Domain\Model\FrontendUserGroup;
use R3H6\OidcServer\Event\ModifyUserClaimsEvent;

final class AddRolesClaim
{
    public function __invoke(ModifyUserClaimsEvent $event): void
    {
        $event->setClaims(array_merge($event->getClaims(), [
            'Roles' => implode(', ', array_map(fn(FrontendUserGroup $group): string => str_replace(',', ' ', $group->getTitle()), $event->getUser()->getUsergroup()->toArray())),
        ]));
    }
}
